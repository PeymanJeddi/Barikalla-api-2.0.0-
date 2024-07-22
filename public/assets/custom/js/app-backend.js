window.DestroyField = function ($link,$datatable) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success btn-lg',
            cancelButton: 'btn btn-danger  btn-lg'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'آیا از این کار اطمینان دارید؟',
        text: 'در صورت پاک شدن داده امکان بازگردانی وجود ندارد!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله',
        cancelButtonText: 'خیر',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            axios.delete($link)
            .then(function (response){
                $($datatable).DataTable().ajax.reload();
                swalWithBootstrapButtons.fire(
                    'حذف!',
                    'داده مورد نظر شما حذف گردید.',
                    'success'
                )
            })
            .catch(function (error){
                swalWithBootstrapButtons.fire(
                    'خطا!',
                    'عملیات با خطا مواجه شد',
                    'error',
                )
            })
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'انصراف',
                'عملیات حذف کنسل گردید',
                'error'
            )
        }
    })
}
window.getLoaded = function ($link ,  $target){
    axios.post($link).then(({data})=>{
        let selectbox = $($target);
        selectbox.empty()
        data.forEach(function (option) {
            let optionElement = new Option(option.name, option.id, false, false);
            selectbox.append(optionElement);
        });
        selectbox.trigger('change');
    })
}
