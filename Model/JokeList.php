<?php
namespace JokeSite;
class JokeList {
	private $pdo;
	private $sort = 'oldest';
	private $keyword;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function sort($dir): self {
		$model = clone $this;
		$model->sort = $dir;
		return $model;
	}


	public function search($keyword) {
		$model = clone $this;

		$model->keyword = $keyword;

		return $model;

	}

	public function getKeyword() {
		return $this->keyword;
	}

	public function getSort() {
		return $this->sort;
	}

	public function delete($id): self {
		$stmt = $this->pdo->prepare('DELTE FROM joke WHERE id = :id');
		$stmt->execute([':id' => $id]);

		return $this;
	}

	public function getJokes() {
		$parameters = [];

		if ($this->sort == 'newest') {
			$order = ' ORDER BY id DESC';
		}
		else if ($this->sort == 'oldest') {
			$order = ' ORDER BY id ASC';
		}
		else {
			$order = '';
		}


		if ($this->keyword) {
			$where = ' WHERE text LIKE :text';
			$parameters['text'] = '%' . $this->keyword . '%';
		}
		else {
			$where = '';
		}


		$stmt = $this->pdo->prepare('SELECT * FROM joke ' . $where . $order);
		$stmt->execute($parameters);

		return $stmt->fetchAll();
	}
}