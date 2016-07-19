<?php

class Get_model extends CI_Model{
		
	function getData(){
		$query=$this->db->get('form_data');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function count_rows(){
    	return $this->db->count_all('sw_post');
	}
	function count_rows_byAuthor(){
		if($this->insert_model->is_admin()){
			return $this->db->count_all('sw_post');
		}else{
			$this->db->where('author',$this->session->userdata('user_name'));
			$query=$this->db->get('sw_post');
			return  $query->num_rows();
		}
	}
	function getAuthorByUsername($author){
		$this->db->where('user_name',$author);
		$query = $this->db->get('sw_user_details');
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return 0;
		}
	}
	function count_rows_articleManagement(){
		$this->db->where('status !=','draft');
		$this->db->where('status !=','active');
		$query = $this->db->get('sw_post');
		if($query){
			return $query->num_rows();
		}else{
			return 0;
		}
	}
	function count_rows_by_slug($cat){
		$this->db->like('cat',$cat);
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->num_rows();
		}else{
			return FALSE;
		}
	}
	function count_sports_rows_by_slug($cat){
		$this->db->like('sports_cat',$cat);
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->num_rows();
		}else{
			return FALSE;
		}
	}
	function count_post_by_author($author){
		$this->db->where('author',$author);
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->num_rows();
		}else{
			return FALSE;
		}
	}
	function get_all_postByLimit($limit,$start){
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
		if($this->insert_model->is_admin()){
			$this->db->where('status !=','pending');
		}else{
			$this->db->where('status','draft');
			$this->db->where('author',$this->session->userdata('user_name'));
		}
		$query=$this->db->get('sw_post');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function get_all_post_byLimit($limit,$start){
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
		$this->db->where('status !=','draft');
		$this->db->where('status !=','active');
		$query=$this->db->get('sw_post');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function get_all_post(){
		$query=$this->db->get('sw_post');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function searchPost($data){
		$this->db->like('title',$data['title']);
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function countPostByTeamSlug($slug){
		$this->db->like('team',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->num_rows();
		}else{
			return FALSE;
		}
	}
	function getPostByTeamSlug($limit,$start,$team){
		$this->db->limit($limit,$start);
		$this->db->where('status','active');
		$this->db->order_by("id", "desc");
		$this->db->like('team',$team);
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function countPostByEventSlug($slug){
		$this->db->like('event',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->num_rows();
		}else{
			return FALSE;
		}
	}
	function getPostByEventSlug($limit,$start,$event){
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
		$this->db->like('event',$event);
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function countPostByPlayerSlug($slug){
		$this->db->like('player',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->num_rows();
		}else{
			return FALSE;
		}
	}
	function getPostByPlayerSlug($limit,$start,$player){
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
		$this->db->like('player',$player);
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getTeamDetailsBySlug($team){
		$this->db->where('slug',$team);
		$query=$this->db->get('sw_team_tag');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getEventDetailsBySlug($event){
		$this->db->where('slug',$event);
		$query=$this->db->get('sw_event_tag');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getPlayerDetailsBySlug($player){
		$this->db->where('slug',$player);
		$query=$this->db->get('sw_player_tag');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
		
	function get_all_advertise(){
		$query=$this->db->get('sw_advertise');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getAdById($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_advertise');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getMyDetails(){
		$this->db->where('uid',$this->session->userdata('uid'));
		$query=$this->db->get('sw_user_details');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getSingleUserDetailsByUsername($user_name){
		$this->db->where('user_name',$user_name);
		$query=$this->db->get('sw_user_details');	
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getNameByUseName($user_name){
		$this->db->where('user_name',$user_name);
		$query=$this->db->get('sw_user_details');	
		if($query->num_rows()==1){
			$row=$query->row();
			return $row->name;
		}else{
			return false;
		}
	}
	function getEmailByUseName($user_name){
		$this->db->where('user_name',$user_name);
		$query=$this->db->get('sw_user_details');	
		if($query->num_rows()==1){
			$row=$query->row();
			return $row->email;
		}else{
			return false;
		}
	}
	function getMyFollowers($user_name){
		$this->db->where('user_name',$user_name);
		$query=$this->db->get('sw_favourite_author');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getFollowing($uid){
		$this->db->where('my_uid',$uid);
		$query=$this->db->get('sw_favourite_author');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getMyPost($uid){
		$this->db->where('uid',$uid);
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function countMyPost($author){
		$this->db->where('author',$author);
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getPostPublishedTeam($slug){
		$this->db->like('team',$slug);
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getPostPublishedPlayer($slug){
		$this->db->like('player',$slug);
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getPostPublishedEvent($slug){
		$this->db->like('event',$slug);
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getEditorsPickTeam($slug){
		$this->db->like('team',$slug);
		$this->db->like('cat','editors-pick');
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getEditorsPickPlayer($slug){
		$this->db->like('player',$slug);
		$this->db->like('cat','editors-pick');
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getEditorsPickEvent($slug){
		$this->db->like('event',$slug);
		$this->db->like('cat','editors-pick');
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getReadsReceivedTeam($slug){
		$this->db->like('team',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			$count=0;
			foreach ($query->result() as $row){
				$count = $count + $row->view;
			}
			return $count;
		}else{
			return false;
		}
	}
	function getReadsReceivedPlayer($slug){
		$this->db->like('player',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			$count=0;
			foreach ($query->result() as $row){
				$count = $count + $row->view;
			}
			return $count;
		}else{
			return false;
		}
	}
	function getReadsReceivedEvent($slug){
		$this->db->like('event',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			$count=0;
			foreach ($query->result() as $row){
				$count = $count + $row->view;
			}
			return $count;
		}else{
			return false;
		}
	}
	function getMyPostAsEditor($uid){
		$this->db->where('uid',$uid);
		$this->db->like('cat','editors-pick');
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getMyPostRead($author){
		$this->db->where('author',$author);
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			$count=0;
			foreach ($query->result() as $row){
				$count = $count + $row->view;
			}
			return $count;
		}else{
			return false;
		}
	}
	function getLatestPost(){
		$this->db->limit(4);
		$this->db->order_by("id", "desc");
		//$this->db->not_like("cat", "videos");
		$this->db->where('status','active');
		$query=$this->db->get('sw_post');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getLatest15(){
		$this->db->limit(15);
		$this->db->order_by("id", "desc");
		$this->db->where('status','active');
		$query=$this->db->get('sw_post');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getPopularPost(){
		$this->db->limit(4);
		$this->db->order_by("view", "desc");
		$this->db->where('status','active');
		$query=$this->db->get('sw_post');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getPostByID($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_post');
		if($query->num_rows()==1){
			return $query->result();
		}else{
			return false;
		}
	}
	function getSinglePostBySlug($slug){
		$this->db->where('slug',$slug);
		$this->db->where('status','active');
		$query=$this->db->get('sw_post');
		if($query->num_rows()==1){
			return $query->result();
		}else{
			return false;
		}
	}
	function getPostsBySlug($slug){
		$this->db->limit(4);
		$this->db->order_by("id", "desc");
		$this->db->where('status','active');
		$this->db->like('cat',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getPostsBySlugforSlider($slug){
		$this->db->limit(7);
		$this->db->order_by("id", "desc");
		$this->db->where('status','active');
		$this->db->like('cat',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getPostsBySlugfront($limit,$start,$slug){
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
		$this->db->like('cat',$slug);
		$this->db->where('status','active');
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getPostsBySportsSlug($limit,$start,$slug){
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
		$this->db->like('sports_cat',$slug);
		$this->db->where('status','active');
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function load_data($data){
		$this->db->order_by("id", "desc");
		$this->db->like('sports_cat',$data['slug']);
		$this->db->where('status','active');
        $query = $this->db->get('sw_post',$data['num'],0);
        if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
    }
	function getTeamBySportsSlug($slug){
		
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows()==1){
			$row=$query->row();
			$sports_id=$row->id;
			
			$this->db->limit(5);
			$this->db->order_by('id','DESC');
			$this->db->where('sports',$sports_id);
			$query=$this->db->get('sw_team_tag');
			return $query->result();
		}else{
			return false;
		}
	}
	function getPlayerBySportsSlug($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows()==1){
			$row=$query->row();
			$sports_id=$row->id;
			
			$this->db->limit(5);
			$this->db->order_by('id','DESC');
			$this->db->where('sports',$sports_id);
			$query=$this->db->get('sw_player_tag');
			return $query->result();
		}else{
			return false;
		}
	}
	function getPlayerBySportsSlugFull($limit,$start,$slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows()==1){
			$row=$query->row();
			$sports_id=$row->id;
			$this->db->limit($limit,$start);
			$this->db->where('sports',$sports_id);
			$query=$this->db->get('sw_player_tag');
			return $query->result();
		}else{
			return false;
		}
	}
	function getEventBySportsSlug($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows()==1){
			$row=$query->row();
			$sports_id=$row->id;
			
			$this->db->limit(5);
			$this->db->order_by('id','DESC');
			$this->db->where('sports',$sports_id);
			$query=$this->db->get('sw_event_tag');
			return $query->result();
		}else{
			return false;
		}
	}
	function getTeamNameBySportsSlug($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_team_tag');
		if($query->num_rows()==1){
			$row=$query->row();
			$sports_id=$row->sports;
			
			$this->db->where('id',$sports_id);
			$query=$this->db->get('sw_sports_cat');
			$row=$query->row();
			$slug=$row->slug;
			return $slug;
		}else{
			return false;
		}
	}
	function getTeamNameBySportsID($id){
		$this->db->where('sports',$id);
		$query=$this->db->get('sw_team_tag');
		if($query->num_rows()==1){
			$row=$query->row();
			$slug=$row->slug;
			return $slug;
		}else{
			return false;
		}
	}
	function getPostBtCat($name){
		$this->db->limit(5);
		$this->db->like('cat',$name);
		$this->db->where('status','active');
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getPostforTeamPage($team,$sports,$slug){
		$this->db->limit(5);
		$this->db->like('team',$team);
		$this->db->like('sports_cat',$sports);
		$this->db->like('cat',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getPostforPlayerPage($player,$sports,$slug){
		$this->db->limit(5);
		$this->db->like('player',$player);
		$this->db->like('sports_cat',$sports);
		$this->db->like('cat',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getCatByID($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_cat');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getTeamByID($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_team_tag');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getEventByID($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_event_tag');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getPlayerByID($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_player_tag');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getSportsCatByID($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_sports_cat');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function returnSportsCatName($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows == 1){
			$row=$query->row();
			return $row->name;
		}else{
			return FALSE;
		}
	}
	function returnSportsCatSlug($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows == 1){
			$row=$query->row();
			return $row->slug;
		}else{
			return FALSE;
		}
	}
	function returnTeamName($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_team_tag');
		if($query->num_rows == 1){
			$row=$query->row();
			return $row->name;
		}else{
			return FALSE;
		}
	}
	function checkStatus($id){
		$this->db->where('id',$id);
		$this->db->where('status','active');
		$query=$this->db->get('sw_post');
		if($query->num_rows==1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function checkSWUserStatus($id){
		$this->db->where('id',$id);
		$this->db->where('status','active');
		$query=$this->db->get('user');
		if($query->num_rows==1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function checkRole($id){
		$this->db->where('id',$id);
		$this->db->where('role','Fan');
		$query=$this->db->get('user');
		if($query->num_rows==1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function getAllCat(){
		$this->db->order_by("sort", "asc");
		$query=$this->db->get('sw_cat');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getTeamAll(){
		$query=$this->db->get('sw_team_tag');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getEventAll(){
		$query=$this->db->get('sw_event_tag');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getPlayerAll(){
		$query=$this->db->get('sw_player_tag');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getPlayerAllHome(){
		$this->db->limit(11);
		$query=$this->db->get('sw_player_tag');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getPlayerPicture($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_player_tag');
		if($query){
			$row=$query->row();
			return $row->featured_img;
		}else{
			return FALSE;
		}
	}
	function getAllSportsCat(){
		$this->db->order_by('parent','ASC');
		$this->db->where('parent !=',"");
		$query=$this->db->get('sw_sports_cat');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getUserAll(){
		$this->db->where('user_name !=',$this->session->userdata('user_name'));
		$query=$this->db->get('user');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getAllUser(){
		$query=$this->db->get('user');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getAuthorAll($author){
		$this->db->where('user_name !=',$this->session->userdata('user_name'));
		$this->db->where('user_name !=',$author);
		$this->db->where('role','Editor');
		$this->db->or_where('role','Administrator');

		$this->db->distinct();
		$query=$this->db->get('user');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getAuthorAllNew(){
		$this->db->where('role','Editor');
		$this->db->distinct();
		$query=$this->db->get('user');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function is_i_am($post_id,$author){
		$this->db->where('id',$post_id);
		$this->db->where('author',$author);
		$query=$this->db->get('sw_post');
		if($query->num_rows==1){
			//echo $query->num_rows();
			return True;
		}else{
			return false;
		}
	}
	function is_exists($my_uid,$author){
		$this->db->where('my_uid',$my_uid);
		$this->db->where('user_name',$author);
		$query=$this->db->get('sw_favourite_author');
		if($query->num_rows>0){
			return true;
		}else{
			return FALSE;
		}
	}
	function is_exists_myTeam($my_uid,$team){
		$this->db->where('my_uid',$my_uid);
		$this->db->where('team_id',$team);
		$query=$this->db->get('sw_favourite_team');
		if($query->num_rows>0){
			return true;
		}else{
			return FALSE;
		}
	}
	function is_exists_myPlayer($my_uid,$player){
		$this->db->where('my_uid',$my_uid);
		$this->db->where('player_id',$player);
		$query=$this->db->get('sw_favourite_player');
		if($query->num_rows > 0){
			return true;
		}else{
			return FALSE;
		}
	}
	function is_exists_myEvent($my_uid,$event){
		$this->db->where('my_uid',$my_uid);
		$this->db->where('event_id',$event);
		$query=$this->db->get('sw_favourite_event');
		if($query->num_rows>0){
			return true;
		}else{
			return FALSE;
		}
	}
	function myFavouriteAuthor(){
		$this->db->where('my_uid',$this->session->userdata('uid'));
		$query=$this->db->get('sw_favourite_author');
		if($query->num_rows>0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getUserByUserName($user_name){
		$this->db->where('user_name',$user_name);
		$query=$this->db->get('user');
		if($query){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getUserByID($id){
		$this->db->where('id',$id);
		$query=$this->db->get('user');
		if($query->num_rows==1){
			$row=$query->row();

			$this->db->where('uid',$row->uid);
			$query=$this->db->get('sw_user_details');
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getRoleByUID($uid){
		$this->db->where('uid',$uid);
		$query=$this->db->get('user');
		if($query->num_rows==1){
			$row=$query->row();
			return $row->role;
		}else{
			return FALSE;
		}
	}
	function getUserDetailsAll(){
		if($this->insert_model->is_logged_in()){
			$this->db->where('user_name !=',$this->session->userdata('user_name'));
			$this->db->where('role','Editor');
		}else{
			$this->db->where('role','Editor');
		}
		$query=$this->db->get('user');
		if($query->num_rows > 0){
			foreach ($query->result() as $row){
				$this->db->or_where('uid',$row->uid);
			}
			$query=$this->db->get('sw_user_details');
			if($query->num_rows()>0){
				return $query->result();
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	function getUserByAuthor($author){
		$this->db->where('author',$author);
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getLimitPostByAuthor($author){
		$this->db->limit(3);
		$this->db->where('author',$author);
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getPostByAuthor($limit,$start,$author){
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
		$this->db->where('author',$author);
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function checkUserStatus($uid){
		$this->db->where('uid',$uid);
		$query=$this->db->get('user');
		if($query->num_rows==1){
			$row=$query->row();
			return $row->status;
		}else{
			return FALSE;
		}
	}
	function getCommentsByPostId($post_id){
		$this->db->where('post_id',$post_id);
		$query=$this->db->get('sw_comment');
		if($query->num_rows>0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getPrePost(){
		$this->db->order_by("post_date", "asc");
		$this->db->where('post_type','post');
		$query=$this->db->get('wp_posts');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function insertPrePost($data){
		$query=$this->db->insert('sw_post',$data);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	function getNewsPost(){
		$this->db->limit(5);
		$this->db->order_by("id", "desc");
		$this->db->like('cat','news');
		$query=$this->db->get('sw_post');	
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function checkFollow(){
		$this->db->where('my_uid',$this->session->userdata('uid'));
		$query=$this->db->get('sw_favourite_event');
		if($query->num_rows()>0){
			return true;
		}else{
			$this->db->where('my_uid',$this->session->userdata('uid'));
			$query=$this->db->get('sw_favourite_player');
			if($query->num_rows()>0){
				return true;
			}else{
				$this->db->where('my_uid',$this->session->userdata('uid'));
				$query=$this->db->get('sw_favourite_team');
				if($query->num_rows()>0){
					return true;
				}else{
					return false;
				}
			}
		}
	}
	function getFollowedEvent(){
		$this->db->limit(2);
		$this->db->where('my_uid',$this->session->userdata('uid'));
		$query=$this->db->get('sw_favourite_event');
		if($query->num_rows()>0){
			$i=1;
			foreach ($query->result() as $row){
				if($i==1){
					$this->db->where('id',$row->id);
				}else{
					$this->db->or_where('id',$row->id);
				}
				$i++;
			}
			$query=$this->db->get('sw_event_tag');
			if($query->num_rows()>0){
				return $query->result();
			}
		}else{
			return false;
		}
	}
	function getFollowedPlayer(){
		$this->db->limit(2);
		$this->db->where('my_uid',$this->session->userdata('uid'));
		$query=$this->db->get('sw_favourite_player');
		if($query->num_rows()>0){
			$i=1;
			foreach ($query->result() as $row){
				if($i==1){
					$this->db->where('id',$row->id);
				}else{
					$this->db->or_where('id',$row->id);
				}
				$i++;
			}
			$query=$this->db->get('sw_player_tag');
			if($query->num_rows()>0){
				return $query->result();
			}
		}else{
			return false;
		}
	}
	function getFollowedTeam(){
		$this->db->limit(2);
		$this->db->where('my_uid',$this->session->userdata('uid'));
		$query=$this->db->get('sw_favourite_team');
		if($query->num_rows()>0){
			$i=1;
			foreach ($query->result() as $row){
				if($i==1){
					$this->db->where('id',$row->id);
				}else{
					$this->db->or_where('id',$row->id);
				}
				$i++;
			}
			$query=$this->db->get('sw_team_tag');
			if($query->num_rows()>0){
				return $query->result();
			}
		}else{
			return false;
		}
	}
	function getCommentCount($id){
		$this->db->where('post_id',$id);
		$query=$this->db->get('sw_comment');
		if($query->num_rows()>0){
			return $query->num_rows();
		}
	}
	function getRelatedPost($sports_cat,$id){
		$this->db->limit(6);
		$this->db->order_by("id", "desc");
		$this->db->like('sports_cat',$sports_cat);
		$this->db->where('status','active');
		$this->db->where('id !=',$id);
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	function getAuction(){
		$this->db->order_by("id", "desc");
		$query=$this->db->get('ipl7auction');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getAuction2(){
		$this->db->limit(10);
		$this->db->order_by("id", "desc");
		$query=$this->db->get('ipl7auction');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getAuctionRecent(){
		$this->db->limit(1);
		$this->db->order_by("id", "desc");
		$query=$this->db->get('ipl7auction');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function editUpdates($id){
		$this->db->where('id',$id);
		$query=$this->db->get('ipl7auction');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getBreakingNews(){
		$this->db->limit(1);
		$this->db->order_by("id", "desc");
		$query=$this->db->get('ipl7auction');
		if($query->num_rows()==1){
			return $query->row()->title;
		}else{
			return false;
		}
	}
	function getLatestBreaking(){
		$this->db->limit(10);
		$this->db->order_by("id", "desc");
		$this->db->like('cat','news');
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getBuzz(){
		$this->db->limit(5);
		$this->db->order_by("id", "desc");
		$this->db->where('buzz','true');
		$query=$this->db->get('sw_post');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	//-----------------------------------------Subhomoy Start---------------------------------------------------

	function getIPLteamAll(){
		$query=$this->db->get('sw_ipl_team');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getIPLplayerAll(){
		$query=$this->db->get('sw_ipl_player');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function vote($data){
		$query=$this->db->insert('sw_ipl_pole',$data);
		if($query){
			return true;
		}
		else{
			return false;
		}
	}
	function ipl2014SelectedTeam($data){	
		$this->db->where('team_code',$data['team_code']);
		$this->db->group_by("player_id");
		$query=$this->db->get('sw_ipl_pole');
		if($query->num_rows()>0){
			//echo $query->num_rows();
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	function ipl2014SelectedTeamName($data){
		$this->db->where('team_code',$data['team_code']);
		$query=$this->db->get('sw_ipl_team');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

	function ipl2014PlayerById($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_ipl_player');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

	function ipl2014PlayerRating($id,$team_code){
		$this->db->where('player_id',$id);
		$this->db->where('team_code',$team_code);
		$query=$this->db->get('sw_ipl_pole');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

	function ipl2014MaxPricePlayerByTeam($id,$team_code){
		$this->db->select_max('price');
		$this->db->where('player_id',$id);
		$this->db->where('team_code',$team_code);
		$query=$this->db->get('sw_ipl_pole');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

	function ipl2014MinPricePlayerByTeam($id,$team_code){
		$this->db->select_min('price');
		$this->db->where('player_id',$id);
		$this->db->where('team_code',$team_code);
		$query=$this->db->get('sw_ipl_pole');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

	function ipl2014AvgPricePlayerByTeam($id,$team_code){
		$this->db->select_avg('price');
		$this->db->where('player_id',$id);
		$this->db->where('team_code',$team_code);
		$query=$this->db->get('sw_ipl_pole');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

	function ipl2014TotalVoteByTeam($team_code){
		$this->db->where('team_code',$team_code);
		$query=$this->db->get('sw_ipl_pole');
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}

	function ipl2014TotalVoteByPlayer($id){
		$this->db->where('player_id',$id);
		$query=$this->db->get('sw_ipl_pole');
		if($query->num_rows()>0){
			return $query->num_rows();
		}else{
			return false;
		}
	}

	function ipl2014MaxPricePlayer($id){
		$this->db->select_max('price');
		$this->db->where('player_id',$id);
		$query=$this->db->get('sw_ipl_pole');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

	function ipl2014LowPricePlayer($id){
		$this->db->select_min('price');
		$this->db->where('player_id',$id);
		$query=$this->db->get('sw_ipl_pole');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

	function ipl2014AvgPricePlayer($id){
		$this->db->select_avg('price');
		$this->db->where('player_id',$id);
		$query=$this->db->get('sw_ipl_pole');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	function ipl2014PopularityByPlayerId($p_id){ //Search for player popularity by player id.
		$query=$this->db->get('sw_ipl_pole');
		if($query){
			$total_vote = $query->num_rows();
			$this->db->where('player_id',$p_id);
			$query1=$this->db->get('sw_ipl_pole');
			if($query1->num_rows()){
				$voteby_playerid = $query1->num_rows();
				$player_popularity = ($voteby_playerid / $total_vote) * 100;
				
				return $player_popularity;
			}else{
				return false;
			}
		}
	}

	function ipl2014Popularityforall(){ //Search for player popularity by player id.
		$query = $this->db->get('sw_ipl_player');
		foreach ($query->result() as $row){
			$player_id = $row->id;
			$popularity[$player_id] = $this->ipl2014PopularityByPlayerId($player_id);
		}
		arsort($popularity);
		if($popularity){
			return $popularity;
		}else{
			return false;
		}
		
	}
	function ipl2014Live(){
		$this->db->order_by("id", "desc");
		$query = $this->db->get('sw_ipl_pole');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	function usernameById($uid){
		$this->db->where('uid',$uid);
		$query=$this->db->get('sw_user_details');
		if($query->num_rows() == 1){
			$row=$query->row();
			return $row->name;
		}else{
			return false;
		}
	}
	function playernameById($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_ipl_player');
		if($query->num_rows() == 1){
			$row=$query->row();
			return $row->p_name;
		}else{
			return false;
		}
	}
	function ipl2014TeamNameByTeamId($team_code){
		$this->db->where('team_code',$team_code);
		$query=$this->db->get('sw_ipl_team');
		if($query->num_rows() == 1){
			$row = $query->row();
			return $row->team_name;
		}else{
			return false;
		}
	}
	function user_nameById($uid){
		$this->db->where('uid',$uid);
		$query=$this->db->get('sw_user_details');
		if($query->num_rows() == 1){
			$row=$query->row();
			return $row->user_name;
		}else{
			return false;
		}
	}
	function EmailExistorNot($data){
		$this->db->where('email',$data['email']);
		$query=$this->db->get('sw_user_details');
		if($query->num_rows() == 1){
			$row=$query->row();
			return $row->uid;
		}else{
			return false;
		}
	}
	function ResetPassword($uid){	
		$password = random_string('alnum', 8);
		$data['password'] = sha1($password);
		$this->db->where('uid', $uid);
		$query = $this->db->update('user', $data); 
		if($query){
			return $password;
		}else{
			return false;
		}
	}

	function pass_change($pass){
		$uid = $this->session->userdata('uid');
		$data['password'] = $pass;
		$this->db->where('uid', $uid);
		$query = $this->db->update('user', $data); 
		if($query){
			return $pass;
		}else{
			return false;
		}
	}
	function MailByUid($uid){
		$this->db->where('uid',$uid);
		$query=$this->db->get('sw_user_details');
		if($query->num_rows() == 1){
			$row=$query->row();
			return $row->email;
		}else{
			return false;
		}
	}
	function check_pass($uid,$data){
		$val=array(
			'password'=>sha1($data['password1']),
			);
		$this->db->where('uid', $uid);
		$this->db->where('password', sha1($data['password']));
		$query = $this->db->get('user');
		
		if($query->num_rows() == 1){
			$this->db->where('uid', $uid);
			$query = $this->db->update('user', $val);
			if($query){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	function getEventSlug(){
		$this->db->where('top','true');
		$query=$this->db->get('sw_event_tag');
		if($query->num_rows() == 1){
			return $query->row()->slug;
		}else{
			return false;
		}
	}
	function getPostBySlug($slug){
		$this->db->order_by("id", "desc");
		$this->db->where('status','active');
		$this->db->limit(4);
		$this->db->where('event',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	function countIplt20(){
		$this->db->like('event','ipl');
		$this->db->where('status','active');
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			return $query->num_rows();
		}else{
			return FALSE;
		}
	}
	function getPostBySlugForIPL($limit,$start,$slug){
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
		$this->db->where('status','active');
		$this->db->like('event',$slug);
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	//-----------------------------------------Subhomoy End---------------------------------------------------
	function checkEmailExists($email){
		$this->db->where('email',$email);
		$query=$this->db->get('sw_user_details');
		if($query->num_rows()==1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function getUserLoginData($email){
		$this->db->where('email',$email);
		$query=$this->db->get('sw_user_details');
		if($query->num_rows == 1){
			$this->db->where('uid',$query->row()->uid);
			$query2=$this->db->get('user');
			if($query2->num_rows == 1){
				return $query2->row();
			}else{
				return false;
			}
		}
	}
	function validateUser2($data){
		$userdata=array(
			'user_name'=>$data['user_name'],
			'id'=> $data['id'],
			'uid'=> $data['uid'],
			'is_logged_in'=>true,
			'role'=> $data['role'],
			'status'=> $data['status'],
		);
		$this->session->set_userdata($userdata);
		return true;
	}
	function insertUser($data,$data2){
		$query=$this->db->insert('sw_user_details',$data);
		$query2=$this->db->insert('user',$data2);
		if($query && $query2){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function validateUser($data){
		$this->db->where('user_name',$data['user_name']);
		$this->db->where('password',sha1(($data['password'])));
		$query = $this->db->get('user');
		if($query->num_rows == 1){
			$row=$query->row();
			$userdata=array(
				'user_name'=>$data['user_name'],
				'id'=> $row->id,
				'uid'=> $row->uid,
				'is_logged_in'=>true,
				'role'=> $row->role,
				'status'=> $row->status,
			);
			$this->session->set_userdata($userdata);
			return true;
		}else{
			return false;
		}
	}
//----------------------------Coded By Subhamoy 28/02/14---------------------
	function getplayerdetailbyslug($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_player_tag');
		if($query->num_rows == 1){
			return $query->row();
		}else{
			return false;
		}
	}
	function getteamdetailbyslug($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_team_tag');
		if($query->num_rows == 1){
			return $query->row();
		}else{
			return false;
		}
	}
	function geteventdetailbyslug($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_event_tag');
		if($query->num_rows == 1){
			return $query->row();
		}else{
			return false;
		}
	}
//------------------------------**Day End**-------------------------
//---------------------------*****03/03/14*****---------------------
	
	function GetCategoryByslug($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_cat');
		if($query->num_rows == 1){
			return $query->row();
		}else{
			return false;
		}
	}
	function GetSportsCategoryByslug($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows == 1){
			return $query->row();
		}else{
			return false;
		}
	}
	function getThirdBox(){
		$this->db->limit(1);
		$this->db->order_by("id", "desc");
		$this->db->where('thirdbox_status','true');
		$query=$this->db->get('sw_post');
		if($query->num_rows()==1){
			return $query->row();
		}else{
			return false;
		}
	}
//------------------------------**Day End**-----------------------------
//----------------------------Coded By Subhamoy End---------------------
	function searchPostCount($data){
		$this->db->like('title',$data['title']);
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			return $query->num_rows();
		}else{
			return FALSE;
		}
	}
	function SearchPostbylimit($limit,$start,$data){
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
		$this->db->like('title',$data['title']);
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getEventBySportsSlugFull($limit,$start,$slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows()==1){
			$row=$query->row();
			$sports_id=$row->id;
			$this->db->limit($limit,$start);
			$this->db->where('sports',$sports_id);
			$query=$this->db->get('sw_event_tag');
			return $query->result();
		}else{
			return false;
		}
	}
	function countgetEventBySportsSlugFull($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows()==1){
			$row=$query->row();
			$sports_id=$row->id;
			$this->db->where('sports',$sports_id);
			$query=$this->db->get('sw_event_tag');
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function getTeamBySportsSlugFull($limit,$start,$slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows()==1){
			$row=$query->row();
			$sports_id=$row->id;
			$this->db->limit($limit,$start);
			$this->db->where('sports',$sports_id);
			$query=$this->db->get('sw_team_tag');
			return $query->result();
		}else{
			return false;
		}
	}
	function countTeamBySportsSlugFull($slug){
		$this->db->where('slug',$slug);
		$query=$this->db->get('sw_sports_cat');
		if($query->num_rows()==1){
			$row=$query->row();
			$sports_id=$row->id;
			$this->db->where('sports',$sports_id);
			$query=$this->db->get('sw_team_tag');
			return $query->num_rows();
		}else{
			return false;
		}
	}
	function search_review_editor($data){
		$this->db->where('status', 'active');
		$this->db->where('date >=', $data['strt_date']);
		$this->db->where('date <=', $data['end_date']);
		$this->db->where('author',$data['author']);
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function add_on_off(){
		 $this->db->where('id', 1);
		 $query=$this->db->get('sw_advertise');
		 if($query->num_rows() == 1){
			$row=$query->row();
			$state=$row->state;
			return $state;
		}else{
			return false;
		}
	}

//----------------------------Coded By Subhamoy on 16th May 2014---------------------

	function allpoll(){
		$this->db->order_by("id", "desc");
		$this->db->where("approval", "true");
		$query=$this->db->get('sw_poll');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function allpolls(){
		$this->db->order_by("id", "desc");
		$this->db->where("approval", "true");
		$query=$this->db->get('sw_poll');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getLatestPollsID(){
		$this->db->order_by("id", "desc");
		$this->db->where("approval", "true");
		$this->db->limit(1);
		$query=$this->db->get('sw_poll');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getSinglepollforFront($pieces){
        $pieces = explode(",", $pieces);$i=0;
        $this->db->where('id', $pieces[0]);
        //$this->db->or_where('id', $pieces[1]);
		$query=$this->db->get('sw_poll');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function singlepoll($id){
		$this->db->where('id', $id);
		$query=$this->db->get('sw_poll');
		if($query->num_rows() == 1){
			$row = $query->row();
			return $row;
		}else{
			return FALSE;
		}
	}
	function alreadyvoted($uid,$pollid){
		$this->db->where('poll_id', $pollid);
		$this->db->where('uid', $uid);
		$query=$this->db->get('sw_poll_answer');
		if($query->num_rows() == 1){
			return false;
		}else{
			return true;
		}
	}
	function pollresult($pollid,$total_answers){
		$this->db->where('poll_id', $pollid);
		$query=$this->db->get('sw_poll_answer');
		$total_vote = $query->num_rows();
		if($total_vote > 0){
		for($i=1;$i<=$total_answers;$i++){
			$this->db->where('poll_id', $pollid);
			$this->db->where('answer', $i);
			$query=$this->db->get('sw_poll_answer');	
			$count= $query->num_rows();
			$cal = ($count/$total_vote)*100;
			$percent[$i] = round($cal,2); 
		}
		return $percent;
		
	  }else{
		return false;
	  }
	}
	function titlebyqid($qid){
		$this->db->where('qid', $qid);
		$query=$this->db->get('sw_quiz_title');
		if($query->num_rows() == 1){
			$row = $query->row();
			return $row->title;
		}else{
			return true;
		}	
	
	}
	function allquiz(){
		$this->db->order_by("id", "desc");
		$this->db->where('status', "active");
		$this->db->where('approval', "true");
		$query=$this->db->get('sw_quiz_title');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	
	}
	function singlequiz($qid){
		$this->db->where('qid', $qid);
		$this->db->limit(1);
		$query=$this->db->get('sw_quiz');					
		if($query){
			return $query->row();			
		}else{
			return false;	
		}
	}
	function getresult($qid,$uid){
		$this->db->where('qid', $qid);
		$this->db->where('uid', $uid);
		$query=$this->db->get('sw_quiz_answers');					
		if($query){
			return $query->result();			
		}else{
			return false;	
		}	
	
	}
	function getans($id){
		$this->db->where('id', $id);
		$query=$this->db->get('sw_quiz');					
		if($query->num_rows() == 1){
			$row = $query->row();
			return $row->answer;			
		}else{
			return false;	
		}
	
	}
	function showallanswer($qid){
		$this->db->where('qid', $qid);
		$query=$this->db->get('sw_quiz');					
		if($query->num_rows() > 0){
			return $query->result();			
		}else{
			return false;	
		}	
	
	}
	function checktostart($qid,$uid){
		$this->db->where('qid', $qid);
		$this->db->where('uid', $uid);
		$query=$this->db->get('sw_quiz_answers');
		if($query->num_rows() < 10){
			if($query->num_rows() == 0){
				return true;
			}else{
				$this->db->where('qid', $qid);
				$this->db->where('uid', $uid);
				$query=$this->db->delete('sw_quiz_answers');
				if($query){
					return true;
				}else{
					return false;
				}
			}
		}else{
			if($query->num_rows() == 10){
				return false;		
			}else{
				$this->db->where('qid', $qid);
				$this->db->where('uid', $uid);
				$query=$this->db->delete('sw_quiz_answers');
				if($query){
					return true;
				}else{
					return false;
				}
			
			}
		}	
	
	}
	function getunamebyqid($qid){
		$this->db->where('qid', $qid);
		$this->db->limit(1);
		$query=$this->db->get('sw_quiz');					
		if($query->num_rows() == 1){
			$row = $query->row();
			$uid = $row->uid;
			$name = $this->usernameById($uid);
			return $name; 
		}else{
			return false;	
		}		
	
	}
	function allforum(){
		$this->db->order_by('id', "desc");
		$this->db->where('approval', "true");
		$query=$this->db->get('sw_forum');					
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return false;	
		}	
	
	}
	function EditForumPost($id){
		$this->db->where('id', $id);
		$query=$this->db->get('sw_forum');					
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return false;	
		}		
	}
	function allforumByCategory($category){
		$this->db->where('category', $category);
		//$this->db->where('approval', "true");
		$this->db->order_by("id", "desc");
		$query=$this->db->get('sw_forum');					
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return false;	
		}	
	
	}
	function allforumcat(){
		$this->db->distinct();
		$this->db->select('category');
		$query=$this->db->get('sw_forum');
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return false;	
		}
	}
	function singleForumById($id){
		$this->db->where('id', $id);
		$query=$this->db->get('sw_forum');					
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return false;	
		}		
	
	}
	
	function getAllSlideShow($cat){
		$this->db->where('status', "active");
		$this->db->where('approval', "true");
		$this->db->where('category', $cat);
		$query=$this->db->get('sw_slideshow_title');					
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return false;	
		}	
	
	}
	function SingleSlidetitle($slide_id){
		$this->db->where('slide_id', $slide_id);
		$query=$this->db->get('sw_slideshow_title');					
		if($query->num_rows() == 1){
			$row = $query->row();
			return $row->title; 
		}else{
			return false;	
		}	
	}
	function getSingleSlide($slide_id){
		$this->db->where('slide_id', $slide_id);
		$query=$this->db->get('sw_slideshow_title');					
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return false;	
		}	
	}
	function firstSlide($slide_id){
		$this->db->where('slide_id', $slide_id);
		$this->db->limit(1);
		$query=$this->db->get('sw_slideshow');					
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return false;	
		}
	}
	function getSingleSlideById($id){
		$this->db->where('id', $id);
		$query=$this->db->get('sw_slideshow');					
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return false;	
		}	
	}
	function SlideShowByCat(){
		$this->db->distinct();
		$this->db->select('category');
		$query=$this->db->get('sw_slideshow_title');
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return false;	
		}
	}
	function nextslide($id,$sid){
		$this->db->where('slide_id', $sid);
		$this->db->where('id >', $id);
		$this->db->limit(1);
		$query=$this->db->get('sw_slideshow');					
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return false;	
		}
	}
	function prevslide($id,$sid){
		$this->db->where('slide_id', $sid);
		$this->db->where('id <', $id);
		$this->db->order_by("id", "desc");
		$this->db->limit(1);
		$query=$this->db->get('sw_slideshow');					
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return false;	
		}
	}
	function prev_next_exists($id,$sid){
		$this->db->where('slide_id', $sid);
		$this->db->where('id >', $id);
		$this->db->limit(1);
		$this->db->order_by('id','ASC');
		$query=$this->db->get('sw_slideshow');					
		if($query->num_rows() > 0){
			$check['next'] = true;
			$check['next_row'] = $query->next_row();
		}else{
			$check['next'] = false;
		}
		$this->db->where('slide_id', $sid);
		$this->db->where('id <', $id);
		$this->db->order_by('id','DESC');
		$query=$this->db->get('sw_slideshow');					
		if($query->num_rows() > 0){
			$check['prev'] = true;
			$check['prev_row'] = $query->previous_row();
		}else{
			$check['prev'] = false;	
		}
		return $check; 
	}
	function article_prev_next_exists($id,$cat){
		$this->db->where('id >', $id);
		$this->db->like('sports_cat',$cat);
		$this->db->order_by('id','ASC');
		$query=$this->db->get('sw_post');
		if($query->num_rows() > 0){
			$check['next'] = true;
			$check['next_row'] = $query->next_row();
		}else{
			$check['next'] = false;
		}
		$this->db->where('id <', $id);
		$this->db->like('sports_cat',$cat);
		$this->db->order_by('id','DESC');
		$query=$this->db->get('sw_post');					
		if($query->num_rows() > 0){
			$check['prev'] = true;
			$check['prev_row'] = $query->previous_row();
		}else{
			$check['prev'] = false;	
		}
		return $check;
	}
	function nextArticle($id,$cat){
		$this->db->where('id >', $id);
		$this->db->where('status','active');
		$this->db->like('sports_cat',$cat);
		$this->db->order_by('id','ASC');
		$this->db->limit(1);
		$query=$this->db->get('sw_post');
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return false;	
		}
	}
	function previousArticle($id,$cat){
		$this->db->where('id <', $id);
		$this->db->where('status','active');
		$this->db->like('sports_cat',$cat);
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$query=$this->db->get('sw_post');
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return false;	
		}
	}
	function allslideshow(){
		$this->db->where('status', "active");
		$this->db->where('approval', "true");
		$this->db->order_by('id','DESC');
		$query=$this->db->get('sw_slideshow_title');					
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return false;	
		}	
	
	}
	function allquizes(){
		$this->db->order_by("id", "desc");
		$this->db->where('status', "active");
		//$this->db->where('approval', "true");
		$query=$this->db->get('sw_quiz_title');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	
	}
	function EditPoll($id){
		$this->db->where('id', $id);
		$query=$this->db->get('sw_poll');					
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return false;	
		}	
	}
	function allpendingpolls(){
		$this->db->where('approval !=', "true");
		$query=$this->db->get('sw_poll');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function allpendingforums(){
		$this->db->order_by('id', "desc");
		$this->db->where('approval !=', "true");
		$query=$this->db->get('sw_forum');					
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return false;	
		}	
	
	}
	function EditQuiztitle($qid){
		$this->db->where('qid', $qid);
		$query=$this->db->get('sw_quiz_title');
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return FALSE;
		}	
	
	}
	function EditQuizquestion($qid){
		$this->db->where('qid', $qid);
		$query=$this->db->get('sw_quiz');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}	
	
	}
	function allpendingquiz(){
		$this->db->order_by("id", "desc");
		$this->db->where('status', "active");
		$this->db->where('approval !=', "true");
		$query=$this->db->get('sw_quiz_title');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function allpendingslideshows(){
		$this->db->order_by("id", "desc");
		$this->db->where('status', "active");
		$this->db->where('approval !=', "true");
		$query=$this->db->get('sw_slideshow_title');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function allslideshows(){
		$this->db->order_by("id", "desc");
		$this->db->where('status', "active");
		$this->db->where('approval', "true");
		$query=$this->db->get('sw_slideshow_title');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	
	
	}
	function EditSlidetitle($qid){
		$this->db->where('slide_id', $qid);
		$query=$this->db->get('sw_slideshow_title');
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return FALSE;
		}	
	
	}
	function EditSlideShow($qid){
		$this->db->where('slide_id', $qid);
		$query=$this->db->get('sw_slideshow');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getTeam(){
	    $query = $this->db->get('sw_team_tag');
	    if($query->num_rows > 0){
	    	return $query->result(); 
	    }
	}
	function getPlayer(){
	    $query = $this->db->get('sw_player_tag');
	    if($query->num_rows > 0){
	    	return $query->result(); 
	    }
	}
	function getLastMatch(){
		$this->db->where('id', '1');
		$query=$this->db->get('sw_fifa');
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return FALSE;
		}
	}
	function getNextMatch(){
		$this->db->where('id', '2');
		$query=$this->db->get('sw_fifa');
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return FALSE;
		}
	}
	function getNextToNextMatch(){
		$this->db->where('id', '3');
		$query=$this->db->get('sw_fifa');
		if($query->num_rows() == 1){
			return $query->row();
		}else{
			return FALSE;
		}
	}
	function getPostBySlug2($cat){
		$this->db->limit(4);
		$this->db->order_by('id','DESC');
		$this->db->where('status','active');
		$this->db->like('sports_cat',$cat);
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getMostViewed(){
		$this->db->limit(10);
		$this->db->order_by('view','DESC');
		$this->db->where('status','active');
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getAllQuickLinks(){
		$this->db->order_by('id','DESC');
		$query=$this->db->get('sw_quick_links');
		if($query->num_rows>0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function get10QuickLinks(){
		$this->db->limit(10);
		$this->db->order_by('id','DESC');
		$query=$this->db->get('sw_quick_links');
		if($query->num_rows>0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getAllMeme(){
		$this->db->order_by('id','DESC');
		$this->db->where('type','ADMIN123');
		$query=$this->db->get('sw_meme');
		if($query->num_rows>0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getImageByID($id){
		$this->db->where('id',$id);
		$query=$this->db->get('sw_meme');
		if($query->num_rows>0){
			return $query->row();
		}else{
			return FALSE;
		}
	}
	function saveImg($data){
		$query=$this->db->insert('sw_meme',$data);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	function countThisMonthPost(){
		$this->db->like('date',date("Y-m"));
		$this->db->where('status','active');
		$this->db->where('author',$this->session->userdata('user_name'));
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->num_rows();
		}else{
			return FALSE;
		}
	}
	function getThisMonthPost(){
		$this->db->like('date',date("Y-m"));
		$this->db->where('status','active');
		$this->db->where('author',$this->session->userdata('user_name'));
		$query=$this->db->get('sw_post');
		if($query->num_rows>0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
}