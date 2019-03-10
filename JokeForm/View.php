<?php
namespace JokeForm;
class View {
	public function output(\JokeSite\JokeForm  $model): string {
		$errors = $model->getErrors();

		if ($model->isSubmitted() && empty($errors)) {
			header('location: index.php?route=success');
			die;
		}

		$joke = $model->getJoke();

		$output = '';

		if (!empty($errors)) {
			$output .= '<p>The record could not be saved:</p>';
			$output .= '<ul>';
			foreach ($errors as $error) {
				$output .= '<li>' . $error . '</li>';
			}
			$output .= '</ul>';
		}

		$output .= '<form action="" method="post">
				<input type="hidden" value="' . ($joke['id'] ?? ''). '" name="joke[id]" />
				<textarea name="joke[text]">' . ($joke['text'] ?? '') . '</textarea>
				<input type="submit" value="submit" />
			</form>';


		return $output;

	}
}
