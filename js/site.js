function highlightStar(obj, id) {
	removeHighlight(id);
	$('.ratetable #review-' + id + ' li').each(function (index) {
		$(this).addClass('highlight');
		if (index == $('.ratetable #review-' + id + ' li').index(obj)) {
			return false;
		}
	});
}

function removeHighlightnew() {
	$('.addratetable #addreview' + ' li').removeClass('selected');
	$('.addratetable #addreview' + ' li').removeClass('highlight');
}
function highlightStarnew(obj) {
	removeHighlightnew();
	$('.addratetable #addreview' + ' li').each(function (index) {
		$(this).addClass('highlight');
		if (index == $('.addratetable #addreview' + ' li').index(obj)) {
			return false;
		}
	});
}

function removeHighlight(id) {
	$('.ratetable #review-' + id + ' li').removeClass('selected');
	$('.ratetable #review-' + id + ' li').removeClass('highlight');
}
function addRating(obj, id) {
	$(obj).parent().find("#loader-icon").css("display", "inline-block");
	$('.ratetable #review-' + id + ' li').each(function (index) {
		$(this).addClass('selected');
		$('#review-' + id + ' #rate').val((index + 1));
		if (index == $('.ratetable #review-' + id + ' li').index(obj)) {
			return false;
		}
	});
	$.ajax({
		url: "add-rating-ajax.php",
		data: 'id=' + id + '&rate=' + $('#review-' + id + ' #rate').val(),
		type: "POST",
		success: function () {
			$(obj).parent().find("#loader-icon").hide();
		}
	});
}
function addRatingnew(obj, pid) {
	// $(obj).parent().find("#loader-icon").css("display", "inline-block");
	$('.addratetable #addreview' + ' li').each(function (index) {
		$(this).addClass('selected');
		$('#addreview' + ' #rate').val((index + 1));
		if (index == $('.addratetable #addreview' + ' li').index(obj)) {
			return false;
		}
		// alert(pid);alert($('#addreview' +  ' #rate').val());
	});
}
function addnewrate() {
	// var div=$('#refresh').html();
	$.ajax({
		url: "addrate.php",
		async: false,
		data: 'pid=' + $('#addreview' + ' #pid').val() + '&rate='
			+ $('#addreview' + ' #rate').val() + '&title=' + $('#addreviewtitle #addtitle').val()
			+ '&details=' + $('#addreviewdetails #adddetails').val() + '&aid=' + $('#addreview #aid').val(),
		type: "POST",
		error: function (xhr, status, error) {
			alert(status);
			alert(xhr.responseText);
		},
		success: function (results) {
			location.reload();
			//  $("#custresponses").empty().append($results);
		}
	});
}

printresult = ""
function askgpt() {
	$.ajax({
		url: "chatrequest.php",
		async: false,
		data: 'custquestions=' + $('#cquestions' + ' #custquestions').val() + '&aid=' + $('#caid #aid').val(),
		type: "POST",
		error: function (xhr, status, error) {
			alert(status);
			alert(xhr.responseText);
		},
		success: function (results) {
			// location.reload();
			$("#custresponses").empty()
			printresult = results.replaceAll(/[\r\n]/g, "<br>")
			let res = ""
			const strarr = printresult.split("<br>")
			for (let i = 0; i < strarr.length; i++) {
				setTimeout(function () {
					appendResp(strarr[i])
				}, 250 * i);

			}

		}
	});
}
function starsToPurple(str) {
	let t = "**:"
	if (str.indexOf(t) !== 0) {
		str = "<h5 style='color:#8a28e2;'>" + str.substring(0, str.indexOf(t)).replace("**", "") + "</h5>" + str.substr(str.indexOf(t) + 1)
	}
	return str
}
function appendResp(str) {
	let res = "";
	let rescode="";
	if(str.startsWith("```")){
		res="<pre><code>" +str.substring(3)
		
	}
	else if(str.endsWith("```")){
		res=str.substring(0,str.length-3)+"</pre></code>"
	}
	else if (str.startsWith("### ")) {
		res = "<h4 style='color:#006400;'>" + str.substring(4) + "</h4><br>"

	}
	else if (str.startsWith("# ")) {
		res = "<h5 style='color:#6B8E23;'>" + str.substring(2) + "</h5><br>"

	}
	
	else {
		res = str + "<br>"
	}
	$("#custresponses").append(starsToPurple(res));
}

$(document).ready(function () {
	$('#addbtn').click(function (e) {
		addnewrate();
	});
});
function resetRating(id) {
	if ($('#review-' + id + ' #rate').val() != 0) {
		$('.ratetable #review-' + id + ' li').each(function (index) {
			$(this).addClass('selected');
			if ((index + 1) == $('#review-' + id + ' #rate').val()) {
				return false;
			}
		});
	}
}
function resetRatingnew() {
	if ($('#addreview' + ' #rate').val() != 0) {
		$('.addratetable #addreview' + ' li').each(function (index) {
			$(this).addClass('selected');
			if ((index + 1) == $('#addreview' + ' #rate').val()) {
				return false;
			}
		});
	}
}