'use strict'

const index_pages = {
	'home': 'ajax/homeUser',
	'kelas': 'ajax/kelasUser',
	'kamus': 'ajax/kamusProduk',
	'kelasku': 'settings/kelasku',
	'profile': 'ajax/profileUser',
	'materi': 'ajax/materi'
}
//const currPage = window.location.pathname.split("/");

const loadPage = page => {
	$("#konten").html('')
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
	if (pos > 3) return 0;
	const men = document.querySelectorAll('.tabnav ul li');
	men.forEach(function(item) {
		item.classList.remove('active');
	});
	men[pos].classList.add('active');
}

const copyText = (text) => {
	if (!navigator.clipboard) {
		fallbackCopyTextToClipboard(text);
		return;
	}
	navigator.clipboard.writeText(text).then(function() {
		console.log('Async: Copying to clipboard was successful!');
	}, function(err) {
		console.error('Async: Could not copy text: ', err);
	});
}