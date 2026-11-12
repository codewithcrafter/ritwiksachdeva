<?php
/**
 * RITWIK SACHDEVA - MARKDOWN MANAGEMENT & GENERATION MODULE
 * Generates and synchronizes Markdown files with complete YAML frontmatter from MySQL.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

class MarkdownManager {
    /**
     * Generate or update a Markdown file from a blog database record
     */
    public static function syncBlog(int $blogId): ?string {
        $db = get_db();

        $stmt = $db->prepare("
            SELECT b.*, c.name AS category_name, a.name AS author_name
            FROM blogs b
            LEFT JOIN blog_categories c ON b.category_id = c.id
            LEFT JOIN blog_authors a ON b.author_id = a.id
            WHERE b.id = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => $blogId]);
        $blog = $stmt->fetch();

        if (!$blog) {
            return null;
        }

        // Fetch tags
        $tagStmt = $db->prepare("
            SELECT t.name
            FROM blog_tags t
            JOIN blog_tag_relations btr ON t.id = btr.tag_id
            WHERE btr.blog_id = :id
        ");
        $tagStmt->execute(['id' => $blogId]);
        $tags = $tagStmt->fetchAll(PDO::FETCH_COLUMN);

        // Prepare frontmatter
        $publishedAt = $blog['published_at'] ? date('Y-m-d H:i:s', strtotime($blog['published_at'])) : '';
        $tagsYaml = json_encode($tags, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $yaml = "---\n";
        $yaml .= "id: " . (int)$blog['id'] . "\n";
        $yaml .= 'title: ' . json_encode($blog['title'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= 'slug: ' . json_encode($blog['slug'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= 'author: ' . json_encode($blog['author_name'] ?: 'Ritwik Sachdeva', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= 'category: ' . json_encode($blog['category_name'] ?: 'Uncategorized', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= "tags: " . ($tagsYaml ?: '[]') . "\n";
        $yaml .= 'status: ' . json_encode($blog['status'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= 'isFeatured: ' . ($blog['is_featured'] ? 'true' : 'false') . "\n";
        $yaml .= 'readingTime: ' . (int)$blog['reading_time'] . "\n";
        $yaml .= 'publishedAt: ' . json_encode($publishedAt, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= 'metaTitle: ' . json_encode($blog['meta_title'] ?: $blog['title'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= 'metaDescription: ' . json_encode($blog['meta_description'] ?: $blog['excerpt'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= 'canonicalUrl: ' . json_encode($blog['canonical_url'] ?: (BASE_URL . '/blog/' . $blog['slug'] . '/'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= 'featuredImage: ' . json_encode($blog['featured_image'] ?: '', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= 'schemaType: ' . json_encode($blog['schema_type'] ?: 'BlogPosting', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
        $yaml .= "---\n\n";

        // Body content
        $content = "# " . $blog['title'] . "\n\n";
        if (!empty($blog['excerpt'])) {
            $content .= "> " . trim($blog['excerpt']) . "\n\n";
        }
        $content .= trim($blog['content']) . "\n";

        $fullMarkdown = $yaml . $content;

        // Ensure directory exists
        if (!is_dir(CONTENT_BLOGS_PATH)) {
            mkdir(CONTENT_BLOGS_PATH, 0755, true);
        }

        $filename = $blog['slug'] . '.md';
        $filePath = CONTENT_BLOGS_PATH . '/' . $filename;
        $relPath = 'content/blogs/' . $filename;

        file_put_contents($filePath, $fullMarkdown);

        // Update markdown_file_path in database
        $updateStmt = $db->prepare("UPDATE blogs SET markdown_file_path = :path WHERE id = :id");
        $updateStmt->execute(['path' => $relPath, 'id' => $blogId]);

        return $relPath;
    }

    /**
     * Delete or archive a markdown file when a blog is removed
     */
    public static function deleteMarkdownFile(string $slug): bool {
        $filePath = CONTENT_BLOGS_PATH . '/' . $slug . '.md';
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    /**
     * Sync all blogs in database into markdown files
     */
    public static function syncAll(): int {
        $db = get_db();
        $stmt = $db->query("SELECT id FROM blogs WHERE deleted_at IS NULL ORDER BY id ASC");
        $blogIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $count = 0;
        foreach ($blogIds as $id) {
            if (self::syncBlog((int)$id)) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Simple, high-performance Markdown to HTML converter
     */
    public static function toHtml(string $markdown): string {
        // Strip out frontmatter if present
        if (preg_match('/^---[\r\n]+([\s\S]*?)[\r\n]+---[\r\n]+/', $markdown, $matches)) {
            $markdown = substr($markdown, strlen($matches[0]));
        }

        // Clean up newlines
        $text = str_replace(["\r\n", "\r"], "\n", $markdown);

        // Protect code blocks
        $codeBlocks = [];
        $text = preg_replace_callback('/```([a-zA-Z0-9_-]*)\n([\s\S]*?)\n```/', function($m) use (&$codeBlocks) {
            $key = '%%CODEBLOCK_' . count($codeBlocks) . '%%';
            $lang = $m[1] ? ' class="language-' . htmlspecialchars($m[1], ENT_QUOTES) . '"' : '';
            $codeBlocks[$key] = '<pre><code' . $lang . '>' . htmlspecialchars($m[2], ENT_QUOTES) . '</code></pre>';
            return $key;
        }, $text);

        // Inline code
        $text = preg_replace('/`([^`]+)`/', '<code>$1</code>', $text);

        // Headers
        $text = preg_replace('/^###### (.*?)$/m', '<h6>$1</h6>', $text);
        $text = preg_replace('/^##### (.*?)$/m', '<h5>$1</h5>', $text);
        $text = preg_replace('/^#### (.*?)$/m', '<h4>$1</h4>', $text);
        $text = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $text);
        $text = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $text);

        // Horizontal rules
        $text = preg_replace('/^(\-{3,}|\*{3,}|_{3,})$/m', '<hr>', $text);

        // Blockquotes
        $text = preg_replace('/^> (.*?)$/m', '<blockquote>$1</blockquote>', $text);

        // Bold & Italic
        $text = preg_replace('/\*\*\*(.*?)\*\*\*/', '<strong><em>$1</em></strong>', $text);
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/__([^_]+)__/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/_([^_]+)_/', '<em>$1</em>', $text);

        // Links & Images
        $text = preg_replace('/!\[([^\]]*)\]\(([^)]+)\)/', '<img src="$2" alt="$1" class="img-fluid" loading="lazy">', $text);
        $text = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $text);

        // Tables support
        $text = preg_replace_callback('/((?:^\|.*?\|\n?)+)/m', function($match) {
            $lines = array_filter(array_map('trim', explode("\n", trim($match[1]))));
            if (count($lines) < 2) return $match[1];
            
            $html = '<div class="table-responsive"><table class="table-editorial">';
            $isHeader = true;

            foreach ($lines as $idx => $line) {
                if (preg_match('/^\|[\s\-:|]+\|$/', $line)) {
                    continue; // Divider line
                }
                $cells = array_map('trim', explode('|', trim($line, '|')));
                $html .= '<tr>';
                $tag = $idx === 0 ? 'th' : 'td';
                foreach ($cells as $cell) {
                    $html .= "<$tag>" . $cell . "</$tag>";
                }
                $html .= '</tr>';
            }
            $html .= '</table></div>';
            return $html;
        }, $text);

        // Unordered lists
        $text = preg_replace_callback('/((?:^\s*[-*+]\s+.*?$\n?)+)/m', function($m) {
            $items = preg_replace('/^\s*[-*+]\s+(.*?)$/m', '<li>$1</li>', trim($m[1]));
            return "<ul>\n" . $items . "\n</ul>";
        }, $text);

        // Ordered lists
        $text = preg_replace_callback('/((?:^\s*\d+\.\s+.*?$\n?)+)/m', function($m) {
            $items = preg_replace('/^\s*\d+\.\s+(.*?)$/m', '<li>$1</li>', trim($m[1]));
            return "<ol>\n" . $items . "\n</ol>";
        }, $text);

        // Paragraphs: Split on double newlines
        $paragraphs = explode("\n\n", $text);
        $parsed = [];
        foreach ($paragraphs as $p) {
            $p = trim($p);
            if (empty($p)) continue;
            // Don't wrap if it's already a block element or code placeholder
            if (preg_match('/^<(h[1-6]|ul|ol|table|div|blockquote|hr|pre)/i', $p) || str_starts_with($p, '%%CODEBLOCK_')) {
                $parsed[] = $p;
            } else {
                $parsed[] = '<p>' . nl2br($p) . '</p>';
            }
        }
        $result = implode("\n\n", $parsed);

        // Restore code blocks
        foreach ($codeBlocks as $placeholder => $block) {
            $result = str_replace($placeholder, $block, $result);
        }

        return $result;
    }
}

