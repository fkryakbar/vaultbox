import { initializeApp } from "firebase/app";
import { getStorage, ref, uploadBytesResumable, getDownloadURL, deleteObject } from "firebase/storage";
const firebaseConfig = {
    apiKey: "AIzaSyDFOJ2mJxDx3hwRDQK2STjSGFi4ZqaOqWo",
    authDomain: "vaultbox-f39f3.firebaseapp.com",
    projectId: "vaultbox-f39f3",
    storageBucket: "vaultbox-f39f3.appspot.com",
    messagingSenderId: "766635502160",
    appId: "1:766635502160:web:212a75c675b77df5bbbf55",
    measurementId: "G-37FVXW65NN"
};


const app = initializeApp(firebaseConfig);
const storage = getStorage(app, 'gs://vaultbox-f39f3.appspot.com');
function upload() {
    console.log('upload')
}
function isexist() {
    const file = document.getElementById('file');
    const data = file.files[0]
    const filesize = data.size / 1000000
    const onmbsize = filesize.toFixed(2) + ' MB';
    const path = folder + '/' + data.name;
    const ajax = new XMLHttpRequest()
    ajax.onreadystatechange = () => {
        if (ajax.status == 200 && ajax.readyState == 4) {
            if (ajax.response == 'true') {
                uploadthis(data, path)
            } else {
                const progress = document.getElementById('progressbar');
                progress.innerHTML = '<div class="alert alert-danger" role="alert">Filename already exist</div > ';
            }

        }
    }
    ajax.open('POST', url)
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    ajax.send(`filename=${data.name}&&folder=${folder}&&size=${onmbsize}&&path=${path}`)
}
let assign = document.getElementById('file');
assign.addEventListener('change', isexist);


function uploadthis() {
    const progress = document.getElementById('progressbar');
    progress.innerHTML = '';
    const file = document.getElementById('file');
    const data = file.files[0]
    const path = folder + '/' + data.name
    const storageRef = ref(storage, path);
    const upload = uploadBytesResumable(storageRef, data)
    let myprogress = document.getElementById('bar');
    upload.on('state_changed', (e) => {
        const file = document.getElementById('file');
        file.setAttribute('disabled', '');
        var progress = (e.bytesTransferred / e.totalBytes) * 100;
        var progress = Math.round(progress)
        myprogress.style.display = 'block';
        myprogress.style.width = progress + '%';
        myprogress.innerHTML = progress + '%';
    }, (error) => {
        console.log(error)
    }, (suc) => {
        getDownloadURL(ref(storage, path)).then((fileurl) => {
            const ajax = new XMLHttpRequest()
            ajax.onreadystatechange = () => {
                if (ajax.status == 200 && ajax.readyState == 4) {
                    if (ajax.response == 'true') {
                        Swal.fire(
                            'Uploaded!',
                            'File Uploaded',
                            'success'
                        ).then(result => {
                            if (result.isConfirmed) {
                                window.location.href = window.location.href;
                            }
                        })
                    } else {
                        const progress = document.getElementById('progressbar');
                        progress.innerHTML = '<div class="alert alert-danger" role="alert">Something Went wrong</div > ';
                    }

                }
            }
            ajax.open('POST', url)
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
            ajax.send(`inserturl=${fileurl}&&path=${path}`)

        })


    })

}


function getlink() {
    getDownloadURL(ref(storage, 'fikri/spanduk pusat.cdr')).then((url) => {
        console.log(url)
    })
}
const deletefile = document.getElementById('delete');
if (document.body.contains(deletefile)) {

    deletefile.addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let spinnerdelete = document.getElementById('spinnerdelete');
                spinnerdelete.classList.toggle('d-none');
                const ajax = new XMLHttpRequest()
                ajax.onreadystatechange = () => {
                    if (ajax.status == 200 && ajax.readyState == 4) {
                        console.log(ajax.response)
                        const desertRef = ref(storage, `${deletefile.dataset.ref}`);
                        deleteObject(desertRef).then(() => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then(result => {
                                if (result.isConfirmed) {
                                    spinnerdelete.classList.toggle('d-none');
                                    window.location.href = window.location.href;
                                }

                            })
                        })

                    }
                }
                ajax.open('POST', `${url}`);
                ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                ajax.send(`deletefile=${deletefile.dataset.id}`);



            }
        })

    })
}

const copy = document.getElementById('copy');
const copyspinner = document.getElementById('copyspinner');
copy.addEventListener('click', function () {
    copyspinner.classList.toggle('d-none');
    getDownloadURL(ref(storage, copy.dataset.ref)).then((url) => {
        navigator.clipboard.writeText(url);
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: `link copied to clipboard`
        })
        copyspinner.classList.toggle('d-none');
    })
})
const download = document.getElementById('download');
let downloadspinner = document.getElementById('spinnerdownload');
download.addEventListener('click', function () {
    downloadspinner.classList.toggle('d-none');
    getDownloadURL(ref(storage, download.dataset.ref)).then((url) => {

        var a = document.createElement("a");
        a.href = url;
        a.setAttribute("download", 'fileName');
        a.click();
        downloadspinner.classList.toggle('d-none');

    })
})



