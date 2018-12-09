$(function() {
    $('.dropdown-toggle').dropdown();
});

function readInput(input) {
    var file = input.files[0];
    var filename = file['name'];

    var reader = new FileReader();

    reader.onload = function(e) {
        $("label[for='" + input.id + "']").text(filename);
    }

    reader.readAsDataURL(input.files[0]);
}