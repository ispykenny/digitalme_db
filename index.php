<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<form action="routes/signup.php" method="post">
  <div class="input">
    <input type="text" name="uid" id="newUser" value="">
    <label for="newUser">
      <span class="label-el">Username</span>
      <span class="underline"></span>
    </label>
  </div>
  <div class="input">
    <input type="text" name="email" id="emailu">
    <label for="emailu">
      <span class="label-el">Email Address</span>
      <span class="underline"></span>
    </label>
  </div>
  <div class="input">
    <input type="password" name="password" id="password">
    <label for="password">
      <span class="label-el">Password</span>
      <span class="underline"></span>
    </label>
  </div>
  <div class="input">
    <input type="password" name="password_confirmation" id="password_confirmation">
    <label for="password_confirmation">
      <span class="label-el">Repeat Password</span>
      <span class="underline"></span>
    </label>
  </div>
  <div class="btn-parent">
    <button 
    type="submit" name="signup-submit" class="ls-panel__form-button signedup-btn"><span>Sign Up</span></button>
  </div>
</form> 

<script>
  const form = document.querySelector('form');

  const runForm = event => {
    event.preventDefault();

    const formData = new FormData(event.currentTarget);
    
    fetch('routes/signup.php', {
      method: 'post',
      body: formData
    }).then((res) => res.json())
    .then((data) => console.log(data))
    .catch((error) => console.log(error))
  }


  form.addEventListener('submit', event => runForm(event))
</script>
</body>
</html>