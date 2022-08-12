import { initializeApp } from "firebase/app";
import { getStorage, ref, deleteObject, listAll } from "firebase/storage";
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

let deletevault = document.getElementById('deletevault');
deletevault.addEventListener('click', () => {
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
            const uid = deletevault.dataset.uid;
            const desertRef = ref(storage, `${uid}`);
            const ajax = new XMLHttpRequest()
            ajax.onreadystatechange = () => {
                if (ajax.status == 200 && ajax.readyState == 4) {
                    Swal.fire(
                        'Deleted!',
                        'Your vault has been deleted.',
                        'success'
                    ).then(result => {
                        if (result.isConfirmed) {
                            window.location.href = window.location.href;

                        }

                    })

                }
            }
            ajax.open('POST', `${url}`)
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
            ajax.send(`delete=${uid}`)
            listAll(desertRef).then((res) => {
                for (let i = 0; i <= res.items.length; i++) {
                    let deleteallfile = ref(storage, res.items[i].fullPath);
                    deleteObject(deleteallfile).then(() => {

                    }).catch((error) => {
                        console.log('an error')
                    });
                }

            })


        }
    })
})