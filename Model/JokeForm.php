<?php
namespace JokeSite;
class JokeForm {
	private $pdo;

	/* $submitted: Whether or not the form has been submitted */
	private $submitted = false;

	/* Validation errors of submitted data */
	private $errors = [];

	/* The record being represented. May come from the database or a form submission */
	private $record = [];

	public function __construct(\PDO $pdo, $submitted = false, array $record = [], array $errors = []) {
		$this->pdo = $pdo;
		$this->record = $record;
		$this->submitted = $submitted;
		$this->errors = $errors;
	}

	/*
	* @description load a record from the database
	* @param $id - ID of the record to load from the database
	*/
	public function load(int $id): JokeForm {
		$stmt = $this->pdo->prepare('SELECT * FROM joke WHERE id = :id');
		$stmt->execute(['id' => $id]);
		$record = $stmt->fetch();
		return new JokeForm($this->pdo, $this->submitted, $record);
	}

	/*
	* @description return the record currently being represented
	*              this may have come from the DB or $_POST
	*/
	public function getJoke(): array {
		return $this->record;
	}

	/*
	* @description has the form been submitted or not?
	*/
	public function isSubmitted(): bool {
		return $this->submitted;
	}

	/*
	* @description return a list of validation errors in the current $record
	*/
	public function getErrors(): array {
		return $this->errors;
	}


	/*
	* @description attempt to save $record to the database, insert or update
    *			   depending on whether $record['id'] is set
	*/
	public function save(array $record): JokeForm {
		$errors = $this->validate($record);

		if (!empty($errors)) {
			// Return a new instance with $record set to the form submission
			// When the view displays the joke, it will display the invalid
			// form submission back in the box
			return new JokeForm($this->pdo, true, $record, $errors);
		}

		if (!empty($record['id'])) {
			return $this->update($record);
		}
		else {
			return $this->insert($record);
		}
	}

	/*
	* @description validates $record
	*/
	private function validate(array $record): array {
		$errors = [];

		if (empty($record['text'])) {
			$errors[] = 'Text cannot be blank';
		}

		return $errors;
	}

	/*
	* @description save the record using an UPDATE query
	*/
	private function update(array $record): JokeForm {
		$stmt = $this->pdo->prepare('UPDATE joke SET text = :text WHERE id = :id');
		$stmt->execute($record);

		return new JokeForm($this->pdo, true, $record);
	}

	/*
	* @description save the record using an INSERT query
	*/
	private function insert(array $record): JokeForm {
		$stmt = $this->pdo->prepare('INSERT INTO joke (text) VALUES(:text)');

		$stmt->execute(['text' => $record['text']]);

		$record['id'] = $this->pdo->lastInsertId();

		return new JokeForm($this->pdo, true, $record);
	}
}