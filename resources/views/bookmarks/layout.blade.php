<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>

    <title>Bookmarks</title>
</head>
<body>

@yield('content')

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/brands.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        /** Найдем все формы удаления в документе и навесим событие */
        let remove_forms = document.getElementsByClassName('remove_form');
        for (let remove_form of remove_forms) {
            remove_form.addEventListener('submit', removeProcess, false);
        }
    });

    /**
     * Добавляем в форму новое поле которое пользователь вводит через prompt и затем сабмитим форму
     * @param e
     */
    function removeProcess(e) {
        e.preventDefault();
        // let formData = new FormData(this);
        // console.log(formData);
        let token = prompt('Enter password for remove:');
        //formData.append('token', token);

        let newInput = document.createElement("INPUT");
        newInput.setAttribute("type", "hidden");
        newInput.setAttribute("name", "token");
        newInput.setAttribute("value", token);
        this.appendChild(newInput);
        // console.log(this);
        this.submit();
    }

</script>

</body>
</html>
