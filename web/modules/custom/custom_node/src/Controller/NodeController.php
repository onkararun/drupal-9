<?php 
namespace Drupal\custom_node\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

Class NodeController extends ControllerBase{
	

	/**
	 * Creates a node.
	 */
	public function createNode() {
	    $article = [
	      'title' => 'Hello, World!',
	      'body' => 'This is a node created in code.',
	    ];
	    $newArticleNode = $this->createArticleNode($article);
	    $element = [
	         '#markup' => '<p>' . t('Created new article node.') . '</p>',
	    ];
	    return $element;
	}

	protected function createArticleNode($article) {
	    $new_article = Node::create(['type' => 'article']);
	    $new_article->set('title', $article['title']);
	    $new_article->set('body', $article['body']);
	    $new_article->set('uid',1);
	    $new_article->status = 1;
	    $new_article->enforceIsNew();
	    $new_article->save();
	    return true;
	}
 }
