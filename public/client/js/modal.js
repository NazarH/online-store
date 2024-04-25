$(document).ready(function(){
    $('.modal').addClass('hidden');

    $('#showLoginModal').click(function(){
        $('#backForForm').removeClass('hidden');
        $('#loginModal').removeClass('hidden');
        $('#registerModal').addClass('hidden');
    });

    $('#showRegisterModal').click(function(){
        $('#backForForm').removeClass('hidden');
        $('#registerModal').removeClass('hidden');
        $('#loginModal').addClass('hidden');
    });

    $('#closeLogin').click(function(){
        $('#backForForm').addClass('hidden');
        $('#loginModal').addClass('hidden');
    });

    $('#closeRegister').click(function(){
        $('#backForForm').addClass('hidden');
        $('#registerModal').addClass('hidden');
    });
});
