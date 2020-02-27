<?php

class Team{

	private $id;
	private $name;
	private $mascot;
	private $sport;
	private $league;
	private $season;
	private $picture;
	private $homecolor;
	private $awaycolor;
	private $maxplayers;

	public function AllString(){


		$bigString = "";
		$bigString .= 
	   "<tr>
		<td>>$this->id</td>
		<td>$this->name </td>
		<td>$this->mascot </td>
		<td>$this->sport </td>
		<td>$this->league </td>
		<td>>$this->season</td>
		<td>$this->picture </td>
		<td>$this->homecolor </td>
		<td>$this->awaycolor </td>
		<td>$this->maxplayers </td>
		</tr>";


		return $bigString;

	}


}