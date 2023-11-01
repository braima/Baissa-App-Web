<div class="container">
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <img src="{{ asset('assets/img/logo-dark.png') }}" alt="" class="img-responsive" style="width: 150px;display: block;margin: auto;">
        </div>
        <div class="col-md-6"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div style="border: 5px solid #d0ab4d;color:#000;text-align: center;padding: 25px;">
            <h1 style="text-transform: capitalize;">Bonjour,</h1>
            <hr>

            <p>Ce message envoyé par <b>{{$fullname}}</b> demandant des informations depuis la page contact.</p>
    
            <br><br>
            
            <table id="myTable" class="table table-striped" style="width: 100%;text-align: left;margin: auto;">
                <tr>
                    <th scope="col" style="width: 20%;">Nom Complet. </th>
                    <td> {{ $fullname }}</td>
                </tr>
                <tr>
                    <th scope="col" style="width: 20%;">Email. </th>
                    <td> {{ $email}}</td>
                </tr>
                <tr>
                    <th scope="col" style="width: 20%;">Objet. </th>
                    <td> {{ $object}}</td>
                </tr> 
                <tr>
                    <th scope="col" style="width: 20%;">Message.</th>
                    <td> {{$comment}}</td>
                </tr>
              </table>
              <hr>
            
            <p>Merci ! </p>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
</div>

<p style="font-style: italic;color: #9c9c9c;">Envoi de courrier depuis le site officiel de baissa.</p>