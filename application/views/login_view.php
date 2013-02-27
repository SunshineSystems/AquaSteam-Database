     <h1>Login</h1>
        <div id="form">
            Username: <input id="loginUsername" type="text" /><br>
            Password: <input id="loginPassword" type="password" /><br>
            <button id="loginButton" onclick="verifyLogin()" class="btn" >Login</button>
            
        </div>

    <script>
        
        function verifyLogin() {
           var username = $("#loginUsername").val();
           var password = $("#loginPassword").val();
           alert(username +' : '+ password);
        }
        
    </script>
    </body>
</html>
