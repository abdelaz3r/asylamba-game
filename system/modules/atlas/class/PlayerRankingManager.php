<?php

/**
 * PlayerRankingManager
 *
 * @author Jacky Casas
 * @copyright Asylamba
 *
 * @package Atlas
 * @version 04.06.14
 **/

class PlayerRankingManager extends Manager {
	protected $managerType = '_PlayerRanking';

	public function load($where = array(), $order = array(), $limit = array()) {
		$formatWhere = Utils::arrayToWhere($where, 'pl.');
		$formatOrder = Utils::arrayToOrder($order);
		$formatLimit = Utils::arrayToLimit($limit);

		$db = DataBase::getInstance();
		$qr = $db->prepare('SELECT pl.*,
			p.rColor AS color,
			p.name AS name
			FROM playerRanking AS pl
			LEFT JOIN player AS p 
				ON pl.rPlayer = p.id
			' . $formatWhere . '
			' . $formatOrder . '
			' . $formatLimit
		);

		foreach($where AS $v) {
			if (is_array($v)) {
				foreach ($v as $p) {
					$valuesArray[] = $p;
				}
			} else {
				$valuesArray[] = $v;
			}
		}

		if(empty($valuesArray)) {
			$qr->execute();
		} else {
			$qr->execute($valuesArray);
		}

		while($aw = $qr->fetch()) {
			$pl = new playerRanking();

			$pl->id = $aw['id']; 
			$pl->rRanking = $aw['rRanking'];
			$pl->rPlayer = $aw['rPlayer']; 
			$pl->general = $aw['general'];
			$pl->generalPosition = $aw['generalPosition'];
			$pl->generalVariation = $aw['generalVariation'];
			$pl->experience = $aw['experience'];
			$pl->experiencePosition = $aw['experiencePosition'];
			$pl->experienceVariation = $aw['experienceVariation'];
			$pl->victory = $aw['victory'];
			$pl->victoryPosition = $aw['victoryPosition'];
			$pl->victoryVariation = $aw['victoryVariation'];
			$pl->defeat = $aw['defeat'];
			$pl->defeatPosition = $aw['defeatPosition'];
			$pl->defeatVariation = $aw['defeatVariation'];
			$pl->ratio = $aw['ratio'];
			$pl->ratioPosition = $aw['ratioPosition'];
			$pl->ratioVariation = $aw['ratioVariation'];

			$pl->color = $aw['color'];
			$pl->name = $aw['name'];

			$currentT = $this->_Add($pl);
		}
	}

	public function add(playerRanking $pl) {
		$db = DataBase::getInstance();
		$qr = $db->prepare('INSERT INTO
			playerRanking(rRanking, rPlayer, general, generalPosition, generalVariation, 
				experience, experiencePosition, experienceVariation, 
				victory, victoryPosition, victoryVariation, 
				defeat, defeatPosition, defeatVariation, ratio, ratioPosition, ratioVariation)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
		$qr->execute(array(
			$pl->rRanking,
			$pl->rPlayer, 
			$pl->general,
			$pl->generalPosition,
			$pl->generalVariation,
			$pl->experience,
			$pl->experiencePosition,
			$pl->experienceVariation,
			$pl->victory,
			$pl->victoryPosition,
			$pl->victoryVariation,
			$pl->defeat,
			$pl->defeatPosition,
			$pl->defeatVariation,
			$pl->ratio,
			$pl->ratioPosition,
			$pl->ratioVariation
		));

		$pl->id = $db->lastInsertId();

		$this->_Add($pl);
	}

	public function save() {
		$rankings = $this->_Save();

		foreach ($rankings AS $pl) {
			$db = DataBase::getInstance();
			$qr = $db->prepare('UPDATE playerRanking
				SET	id = ?,
					rRanking = ?,
					rPlayer = ?, 
					general = ?,
					generalPosition = ?,
					generalVariation = ?,
					experience = ?,
					experiencePosition = ?,
					experienceVariation = ?,
					victory = ?,
					victoryPosition = ?,
					victoryVariation = ?,
					defeat = ?,
					defeatPosition = ?,
					defeatVariation = ?,
					ratio = ?,
					ratioPosition = ?,
					ratioVariation = ?
				WHERE id = ?');
			$qr->execute(array(
				$pl->id,
				$pl->rRanking,
				$pl->rPlayer, 
				$pl->general,
				$pl->generalPosition,
				$pl->generalVariation,
				$pl->experience,
				$pl->experiencePosition,
				$pl->experienceVariation,
				$pl->victory,
				$pl->victoryPosition,
				$pl->victoryVariation,
				$pl->defeat,
				$pl->defeatPosition,
				$pl->defeatVariation,
				$pl->ratio,
				$pl->ratioPosition,
				$pl->ratioVariation,
				$pl->id
			));
		}
	}
}
?>