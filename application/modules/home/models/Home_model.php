<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home_model extends CI_Model {

	public function __construct()
    { 
        parent::__construct();
        $this->load->database('default', true);
    }

    public function current_league($date)
    {
        $this->db->select()->from('league');
        $this->db->where('start_date <=', $date);
        $this->db->where('end_date >=', $date);

        $res = $this->db->get()->result();

        if($res){
            return $res;
        }else{
            return 0;
        }
    }

    public function previous_league($date)
    {
        $this->db->select()->from('league');
        $this->db->where('end_date <', $date);

        $res = $this->db->get()->result();

        if($res){
            return $res;
        }else{
            return 0;
        }
    }

    public function upcoming_league($date)
    {
        $this->db->select()->from('league');
        $this->db->where('start_date >', $date);

        $res = $this->db->get()->result();

        if($res){
            return $res;
        }else{
            return 0;
        }
    }

    public function league_details($id)
    {
        $this->db->select()->from('league');
        $this->db->where('id', $id);

        $res = $this->db->get()->row_array();

        if($res){
            return $res;
        }else{
            return 0;
        }
    }

    public function matches($id)
    {
        $this->db->select('
                            matches.id as match_id,
                            matches.name as match_name,
                            matches.venue as match_venue,
                            matches.date as match_date,
                            matches.start_time as match_start_time,
                            matches.match_type as match_match_type,
                            matches.winning_team as match_winning_team,
                            matches.result_desc as match_result_desc,
                            team_1.id as team_1_id,
                            team_1.name as team_1_name,
                            team_1.country as team_1_country,
                            team_2.id as team_2_id,
                            team_2.name as team_2_name,
                            team_2.country as team_2_country
                        ')->from('matches');
        $this->db->join('teams as team_1', 'team_1.id = matches.team_1');
        $this->db->join('teams as team_2', 'team_2.id = matches.team_2');
        $this->db->where('matches.league', $id);

        $res = $this->db->get()->result();

        if($res) {
            return $res;
        } else {
            return 0;
        }
    }


    public function match($id)
    {
        $this->db->select('
                            matches.id as match_id,
                            matches.name as match_name,
                            matches.venue as match_venue,
                            matches.date as match_date,
                            matches.start_time as match_start_time,
                            matches.match_type as match_match_type,
                            matches.winning_team as match_winning_team,
                            matches.result_desc as match_result_desc,
                            summary.team_1_score,
                            summary.team_2_score,
                            summary.player_of_match,
                            summary.details,
                            players.name as player_name,
                            players.dob as player_dob,
                            players.description as player_details,
                            team_1.id as team_1_id,
                            team_1.name as team_1_name,
                            team_1.country as team_1_country,
                            team_2.id as team_2_id,
                            team_2.name as team_2_name,
                            team_2.country as team_2_country
                        ')->from('matches');
        $this->db->join('match_summary as summary', 'summary.match_id = matches.id');
        $this->db->join('teams as team_1', 'team_1.id = matches.team_1');
        $this->db->join('teams as team_2', 'team_2.id = matches.team_2');
        $this->db->join('players', 'players.id = summary.player_of_match');
        $this->db->where('matches.league', $id);

        $res = $this->db->get()->row_array();

        if($res) {
            return $res;
        } else {
            return 0;
        }
    }
}
?>