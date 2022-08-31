import Swal from 'sweetalert2'
//Delete section
window.addEventListener('delete-option-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment',
        text: "supprimer la option ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('optionListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//Delete option
window.addEventListener('delete-section-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous ',
        text: "supprimer l'option ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('SectionListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//Delete classe
window.addEventListener('delete-classe-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment',
        text: "supprimer la classe ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('classeListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});


//Delete scolary year
window.addEventListener('delete-scolaryYear-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment',
        text: "supprimer la l'année scolaire ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('scolaryYearListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//Delete cost inscription
window.addEventListener('delete-cost-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment ',
        text: "retirer le fais ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('costListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//Delete other cost
window.addEventListener('delete-cost-other-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment ',
        text: "retirer le fais ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('costOtherListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//Delete devise cost
window.addEventListener('delete-devise-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment ',
        text: "retirer la devise ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deviseOtherListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//Delete student cost
window.addEventListener('delete-student-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment ',
        text: "retirer l'élève ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteStudentListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//Active student cost
window.addEventListener('active-student-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment ',
        text: "marquer abandon ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('activeStudentListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//Active user cost
window.addEventListener('delete-user-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment ',
        text: "retirer l'utilisateur ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteUserListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//Active role cost
window.addEventListener('delete-role-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment ',
        text: "retirer le rôle ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteRoleListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//Active permssion cost
window.addEventListener('delete-depense-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment ',
        text: "retirer la dépense ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('depnseListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});


//delete source depense
window.addEventListener('delete-sourece-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment ',
        text: "retirer la source de dépenses ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('soureceDepenseListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});

//delete source depot
window.addEventListener('delete-depot-dialog',event=>{
    Swal.fire({
        title: 'Voulez-vous vraiment ',
        text: "retirer la depot de dépenses ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('depotListener');
        }
        })
})
window.addEventListener('data-dialog-deleted',event=>{
    Swal.fire(
        'Oprétion !',
        event.detail.message,
        'success'
    );
});
