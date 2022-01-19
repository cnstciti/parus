function showModal(idModal, idContentModal, th) {
    $(idModal).modal('show')
        .find(idContentModal)
        .load(th.attr('data-target'));
};