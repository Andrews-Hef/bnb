$('#add-image').click(function(){
    //je recupere le numero des futurs champs que je vais créer
    const index = +$('#widgets-counter').val();

    //je recupere le prototype des entrées
    const tmpl =$('#ad_images').data('prototype').replace(/__name__/g, index) ;

    //j'injecte ce code au sein de la div
    $('#ad_images').append(tmpl);

    $('#widgets-counter').val(index +1);

    //je gere le bouton supprimer
    handleDeleteButtons();

});

function handleDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;

        $(target).remove();

    });
}

function UpdateCounter(){
    const count = +$('#ad_images div.form-group').length;

    $('#widgets-counter').val(count);
}

 UpdateCounter();
handleDeleteButtons();