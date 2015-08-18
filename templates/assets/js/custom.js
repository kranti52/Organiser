$('document').ready(function() {
    
});

function add_event() {
    
  
}

function add_todo()
{
    $("#todo_button").after(" <li><a href='organise/add?status=todo'><p id='title'>Text Content By clicking</p></a></li>");

}
function add_doing()
{
    $("#doing_button").after(" <li><a href='organise/add?status=doing'><p>Text Content By clicking</p></a></li>");
}
function add_done()
{
    $("#done_button").after(" <li><a href='organise/add?status=done'><p>Text Content By clicking</p></a></li>");
}
function show() {
    
    var value=$('.td_id').val();
    console.log(value);
    $('#tool').append(value);
}