<?php
namespace JokeList;
class Controller {
	public function filterList(\JokeSite\JokeList $jokeList): \JokeSite\JokeList  {
		if (!empty($_GET['sort'])) {
			$jokeList = $jokeList->sort($_GET['sort']);
		}

		if (!empty($_GET['search'])) {
			$jokeList = $jokeList->search($_GET['search']);
		}

		return $jokeList;
	}

	public function delete(\JokeSite\JokeList  $jokeList): \JokeSite\JokeList  {
		return $jokeList->delete($_POST['id']);
	}
}