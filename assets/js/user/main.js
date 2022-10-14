'use strict'

const index_pages = {
	'home': 'ajax/homeUser',
	'kelas': 'ajax/kelasUser',
	'notif': 'ajax/notifUser',
	'profile': 'ajax/profileUser',
	'materi': 'ajax/materi',
	'kelasku': 'settings/kelasku'
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
	const ref = window.localStorage.getItem('ref');
	if (ref == null) {
		loadPage('home');
	} else {
		window.localStorage.removeItem('ref');
		currMenu(Object.keys(index_pages).indexOf(ref));
		loadPage(ref);
	}
});

function ikutKelas(e, kid) {
	let txtType = (e.innerText == 'Keluar') ? 'keluar dari': 'Ikut';
	Swal.fire({
		icon: 'question',
		title: 'Konfirmasi',
		text: 'Apakah kamu akan ' + txtType + ' kelas ini?',
		showDenyButton: true,
		confirmButtonText: 'Iya',
		denyButtonText: `Batal`,
	}).then((result) => {
		if (result.isConfirmed) ajaxIkutKelas(kid);
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

const showMsg = (tipe, msg) => {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	})

	Toast.fire({
		icon: tipe,
		title: msg
	})
}

function currMenu(pos) {
	const men = document.querySelectorAll('.tabnav ul li');
	men.forEach(function(item) {
		item.classList.remove('active');
	});
	men[pos].classList.add('active');
}