<?php

function getOnlineUser($role = null) {
	$ci = &get_instance();
	$uid = myUid();

	if (is_null($role)) {
		return $ci->db
		->from('user_online')
		->where('uid !=', $uid)
		->get()->result();
	} else {
		return $ci->db
		->from('user_online')
		->where('uid !=', $uid)
		->where('role', $role)
		->get()->result();
	}
}

function isOnlineUser($uid) {
	$ci = &get_instance();
	$uid = is_null($uid) ? myUid() : $uid;

	$total = $ci->db
	->from('user_online')
	->where('uid', $uid)
	->count_all_results();
	return ($total > 0);
}

function getOnlineSiswa($guru) {
	$ci = &get_instance();
	$siswaku = $online = [];
	foreach ($ci->Kelas_model->getMyClass() as $i) {
		foreach ($ci->Kelas_model->getAllSiswaByKelas($i->id_kelas) as $usr) {
			array_push($siswaku, $usr->id_user);
		}
	}
	$siswaku = my_array_unique($siswaku);
	$allSiswaOnline = getOnlineUser(2);
	foreach ($siswaku as $val) {
		foreach ($allSiswaOnline as $val2) {
			if ($val2->uid == $val) array_push($online, $val2);
		}
	}
	return my_array_unique($online);
}

function onlineUser() {
	$ci = &get_instance();
	$uid = myUid();
	$ip = $_SERVER['REMOTE_ADDR'];
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$location = current_url();
	$role = (isset($_SESSION['role_id'])) ? $_SESSION['role_id'] : -1;
	$total = $ci->db
	->from('user_online')
	->where('uid', $uid)
	->where('ip', $ip)
	->count_all_results();

	if ($total == 1) {
		$ci->db->update('user_online', [
			'time' => time(),
			'location' => $location,
			'browser' => $browser,
			'role' => $role
		], [
			'uid' => $uid,
			'ip' => $ip
		]);
	} else {
		$ci->db->insert('user_online', [
			'uid' => $uid,
			'ip' => $ip,
			'time' => time(),
			'location' => $location,
			'browser' => $browser,
			'role' => $role
		]);
	}
}

function offlineUser() {
	$ci = &get_instance();
	$tgl = time() - (60*3);
	$ci->db->delete('user_online', [
		'time <=' => $tgl
	]);
}

function unreadNotif($type) {
	$ci = &get_instance();
	$ci->load->model('Notif_model');
	return $ci->Notif_model->getUnread($type);
}

/*function hits() {
	global $sql;
	$user_nama=user_nama();
	$q=mysqli_query($sql,"SELECT hits FROM situs_naecms WHERE user_nama='$user_nama'");
	$arr=mysqli_fetch_array($q);
	$lhits=(int) $arr['hits'];
	$hits= $lhits + 1;
	mysqli_query($sql,"UPDATE situs_naecms SET hits='$hits' WHERE user_nama='$user_nama'");
}*/