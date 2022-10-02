'use strict'

const index_pages = {
	'home': 'ajax/homeUser',
	'kelas': 'ajax/kelasUser',
	'notif': 'ajax/notifUser',
	'profile': 'ajax/profileUser',
	'materi': 'ajax/materi'
}
//const currPage = window.location.pathname.split("/");

function loadPage(page) {
	$("#loader").show();
	$("#konten").load(index_pages[page], function(responseTxt, statusTxt, xhr) {
		if (statusTxt == "success")
			$("#loader").hide();
		if (statusTxt == "error")
			alert("Error: " + xhr.status + ": " + xhr.statusText);
	});
}

$(function() {
	loadPage('home');
});

function ikutKelas(e, kid) {
	let txtType = (e.innerText == 'Keluar') ? 'Keluar dari': 'Ikut';
	Swal.fire({
		title: 'Apakah kamu akan ' + txtType + ' kelas ini?',
		showDenyButton: true,
		confirmButtonText: 'Iya',
		denyButtonText: `Batal`,
	}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.isConfirmed) {
			ajaxIkutKelas(kid);
		}
	});
}

function ajaxIkutKelas(kid) {
	$.ajax({
		url: baseUrl + 'ajax/joinClass',
		method: 'post',
		data: {
			classId: kid
		},
		dataType: 'json',
		success: function(response) {
			console.log(response)
			if (response.status != true) alert(response.msg);
			try {
				Swal.fire('Berhasil!', '', 'success')
				loadPage('kelas');
			} catch (e) {}
		}
	});
}