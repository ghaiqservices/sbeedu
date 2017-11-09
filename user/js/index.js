document.querySelector('#btn').onclick = function(){
	swal("Here's a message!");
};
document.querySelector('button#test-2').onclick = function(){
	swal("Good job!", "You clicked the button!", "success")
};
document.querySelector('button#test-3').onclick = function(){
	swal({   
    title: "Are you sure?",   
    text: "Your will not be able to recover this imaginary file!",   
    type: "warning",   
    showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!" });
};
document.querySelector('button#test-4').onclick = function(){
	swal("Oops...", "Something went wrong!", "error");
};