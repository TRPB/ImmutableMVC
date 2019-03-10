<?php
namespace JokeList;
class View {
	public function output(\JokeSite\JokeList  $model): string {
		$output = '
		<p><a href="index.php?route=edit">Add new joke</a></p>
		<form action="" method="get">
				<input type="hidden" value="filterList" name="route" />
				<input type="hidden" value="' . $model->getSort() . '" name="sort" />
				<input type="text"  placeholder="Enter search text" name="search" />

				<input type="submit" value="submit" />
			</form>

			<p>Sort: <a href="index.php?route=filterList&amp;sort=newest">Newest first</a> | <a href="index.php?route=filterList&amp;sort=oldest">Oldest first</a>
			<ul>

			';

		foreach ($model->getJokes() as $joke) {
			$output .= '<li>' . $joke['text'];

			$output .= ' <a href="index.php?edit=delete&amp;id=' . $joke['id'] . '">Edit</a>';
			$output .= '<form action="index.php?route=delete" method="POST">
						<input type="hidden" name="id" value="' . $joke['id'] . '" />
						<input type="submit" value="Delete" />
						</form>';
			$output .= 	'</li>';
		}

		$output .= '</ul>';
		return $output;

	}
}
