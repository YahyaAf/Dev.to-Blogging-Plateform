<?php

namespace Src\articles;

use PDO;
use PDOException;

class Article {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($data){
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO articles 
                (title, slug, content, excerpt, meta_description, category_id, featured_image, status, scheduled_date, author_id, created_at, updated_at)
                VALUES (:title, :slug, :content, :excerpt, :meta_description, :category_id, :featured_image, :status, :scheduled_date, :author_id, NOW(), NOW())
            ");
            $stmt->execute([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'excerpt' => $data['excerpt'],
                'meta_description' => $data['meta_description'],
                'category_id' => $data['category_id'],
                'featured_image' => $data['featured_image'],
                'status' => $data['status'],
                'scheduled_date' => $data['scheduled_date'],
                'author_id' => $_SESSION['user']['id']
            ]);
    
            $articleId = $this->pdo->lastInsertId();
    
            if (!empty($data['tags'])) {
                $this->addTags($articleId, $data['tags']);
            }
    
            return $articleId;
        } catch (PDOException $e) {
            echo "Erreur lors de la création de l'article : " . $e->getMessage();
            return false;
        }
    }

    public function readAll() {
        try {
            $stmt = $this->pdo->query("
                SELECT a.*, c.name AS category_name, u.username AS author_name, GROUP_CONCAT(t.name) AS tags
                FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.author_id = u.id
                LEFT JOIN article_tags at ON a.id = at.article_id
                LEFT JOIN tags t ON at.tag_id = t.id
                GROUP BY a.id
                ORDER BY a.created_at DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des articles : " . $e->getMessage());
            return [];
        }
    }

    public function read($id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    a.*, 
                    c.name AS category_name, 
                    u.username AS author_name, 
                    GROUP_CONCAT(t.name) AS tags
                FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.author_id = u.id
                LEFT JOIN article_tags at ON a.id = at.article_id
                LEFT JOIN tags t ON at.tag_id = t.id
                WHERE a.id = :id
                GROUP BY a.id
            ");
            $stmt->execute(['id' => $id]);
            $article = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $article ?: null; // Return null if no article is found
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'article : " . $e->getMessage());
            return null;
        }
    }

    public function update($id, $data) {
        try {
            if (empty($data['title']) || empty($data['content']) || empty($data['category_id'])) {
                throw new Exception("Les champs obligatoires sont manquants.");
            }

            $stmt = $this->pdo->prepare("
                UPDATE articles
                SET title = :title, slug = :slug, content = :content, excerpt = :excerpt, meta_description = :meta_description,
                    category_id = :category_id, featured_image = :featured_image, status = :status, scheduled_date = :scheduled_date, updated_at = NOW()
                WHERE id = :id
            ");
            $stmt->execute([
                'id' => $id,
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'excerpt' => $data['excerpt'],
                'meta_description' => $data['meta_description'],
                'category_id' => $data['category_id'],
                'featured_image' => $data['featured_image'],
                'status' => $data['status'],
                'scheduled_date' => $data['scheduled_date']
            ]);

            $this->updateTags($id, $data['tags']);

            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'article : " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateStatus($id, $data) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE articles
                SET status = :status
                WHERE id = :id
            ");
 
            $stmt->execute([
                'id' => $id,
                'status' => $data['status']
            ]);    
            return true;  
        } catch (PDOException $e) {
            error_log("Error updating article: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    

    public function delete($id) {
        try {
            $this->removeTags($id);

            $stmt = $this->pdo->prepare("DELETE FROM articles WHERE id = :id");
            $stmt->execute(['id' => $id]);

            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de l'article : " . $e->getMessage());
            return false;
        }
    }

    private function addTags($articleId, $tags) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO article_tags (article_id, tag_id)
                VALUES (:article_id, :tag_id)
            ");
            foreach ($tags as $tagId) {
                $stmt->execute(['article_id' => $articleId, 'tag_id' => $tagId]);
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout des tags : " . $e->getMessage());
        }
    }

    private function updateTags($articleId, $tags) {
        $this->removeTags($articleId);
        $this->addTags($articleId, $tags);
    }

    private function removeTags($articleId) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM article_tags WHERE article_id = :article_id");
            $stmt->execute(['article_id' => $articleId]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression des tags : " . $e->getMessage());
        }
    }

    private function getTags($articleId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT t.id, t.name
                FROM tags t
                JOIN article_tags at ON t.id = at.tag_id
                WHERE at.article_id = :article_id
            ");
            $stmt->execute(['article_id' => $articleId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des tags : " . $e->getMessage());
            return [];
        }
    }
}
