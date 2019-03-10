<?php
namespace JokeForm;
class Controller {
	public function edit(\JokeSite\JokeForm  $jokeForm): \JokeSite\JokeForm  {
		if (isset($_GET['id'])) {
			return $jokeForm->load($_GET['id']);
		}
		else {
			return $jokeForm;
		}
	}

	public function submit(\JokeSite\JokeForm  $jokeForm): \JokeSite\JokeForm  {
		return $jokeForm->save($_POST['joke']);
	}
}