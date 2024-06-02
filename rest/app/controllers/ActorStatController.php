<?php

class ActorStatController {
    private $userModel;
    private $actorModel;

    public function __construct() {
        $this->actorModel = new Actor();
    }

    public function getActorStat($id) {
        $stats = $this->actorModel->getActorStat($id);
        $years = array();
        $no_nominalization = array();
        $no_wins = array();
        foreach($stats as $stat) {
            $years[] = $stat['year_of_competition'];
            $no_nominalization[] = $stat['total_count'];
            $no_wins[] = $stat['yes_count'];
        }
        http_response_code(200);
        echo json_encode([
            'years' => $years,
            'total' => $no_nominalization,
            'wins'  => $no_wins
        ]);
    }

    public function getActorYearStat($id, $year) {
        $stats = $this->actorModel->getActorYearStat($id, $year);
        http_response_code(200);
        echo json_encode([
            'stat' => $stats
        ]);
    }
}
