// document.querySelector("#f").addEventListener("change", myFunction);
// console.log(x);

// $.ajax({
//     type : 'POST',
//     url : 'url',
//     data : $('#form').serialize() + "&par1=1&par2=2&par3=232"
// }

$.ajax({
	url: "e2.php?x=" + x,
	type: "post",
	success: function (result) {
		console.log(result);
		$("#test").html(result);
	},
});

document.querySelector("#f").addEventListener("change", myFunction);

function myFunction() {
	let x = document.querySelector("#f").innerHTML;
	$.ajax({
		type: "post",
		url: `e2.php`,
		data: $("#form").serialize(),
		// data : $('#form').serialize() + "&par1=1&par2=2&par3=232"
		success: function (result) {
			console.log(result);
			$("#test").html(result);
		},
	});
}
