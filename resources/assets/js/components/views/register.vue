
<template>
  <div id="login">
    <div class="body-login">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="judul">
              <h3><img class="logo" src="../img/logo.png">Merchant Portal</h3>
            </div>
            <div class="login-panel panel panel-default">
              <div class="head-login">
                <h3>Register</h3>
              </div>
              <div class="panel-input contact-form">
                <form @submit.prevent="register">
                  <fieldset>
                    <div class="form">
                      <span class="lg">
                          <img src="../img/envelope.png">
                      </span>
                      <div class="styled-input agile-styled-input-top">
                        <input v-model="name" type="text" required="">
                        <label>Name</label>
                        <span></span>
                      </div>
                      <span class="lg">
                          <img src="../img/envelope.png">
                      </span>
                      <div class="styled-input agile-styled-input-top">
                        <input v-model="email" type="email" required="">
                        <label>Email</label>
                        <span></span>
                      </div>
                      <span class="lg1">
                          <img src="../img/lock.png">
                      </span>
                      <div class="styled-input agile-styled-input-top">
                        <input v-model="password" type="password" required>
                        <label>Password</label>
                        <span></span>
                      </div>
                      <span class="lg">
                          <img src="../img/envelope.png">
                      </span>
                      <div class="styled-input agile-styled-input-top">
                        <input v-model="password_confirm" type="password" required="">
                        <label>Confirm Pass</label>
                        <span></span>
                      </div>
                    </div>
                    <!-- Change this to a button or input when using this as a form -->
                    <button type="submit" class="btn btn-lg btn-login">Register</button>
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
    data () {
      return {
        name: '',
        email: '',
        password: '',
        password_confirm: ''
      }
    },
//    methods: {
//      register () {
//        axios({
//          method: 'post',
//          url: 'http://localhost:8081/register',
//          data: {
//            name: this.name,
//            email: this.email,
//            password: this.password,
//            password_confirm: this.password_confirm
//          }
//        })
//      }
//    }
  }
</script>
<style lang="css">
  /*@font-face {*/
    /*font-family: DINPro;*/
    /*src: url('../img/DINPro-Bold.woff') format('woff');*/
  /*}*/
  .judul{
    margin-top: 55%;
    text-align: left;
    margin-bottom: 7%;
  }
  .judul h3{
    font-family: DINPro;
    font-size: 21px;
    font-weight: normal;
    color: #fff;
  }
  .head-login{
    background-color: #fff;
    padding: 7px;
    border-bottom: solid 1px #ccc;
  }
  .head-login h3{
    font-family: DINPro;
    font-size: 19px;
    font-weight: normal;
    color: #530050;
    margin-left: 2%;
  }
  .panel-input{
    padding: 15px;
  }
  .lg{
    position: absolute;
    margin-top: 17px;
    margin-left: -20px;
  }
  .lg1{
    position: absolute;
    margin-top: 24%;
    margin-left: -20px;
  }
  .lupa{
    width: 100%;
    margin-top: -20px!important;

  }
  .lupa a{
    font-family: DINPro;
    color: #8A2785;
  }
  .form{
    margin-top: 6%;
  }

  /*  -------------------------------------------------------*/
  hgroup {   text-align:center;  margin-top: 3em;  opacity: 0.7;  padding: 30px;  background: #f94699;}
  h1, h3 { font-weight: 300; }
  h1 { color: #fff; }
  form {      padding: 30px;    padding-top: 60px;    background: #fff;}
  .powered{    padding: 10px;    margin-top: -16px;    line-height: 25px;    background: #f94699;}
  .powered a {    color: #ddd;    text-decoration: none;}
  .powered a:hover {  font-style:italic;}
  .group {   position: relative;  margin-bottom: 45px; }

  input {  font-size: 18px;  padding: 10px 10px 10px 5px;  -webkit-appearance: none;  display: block;  background: transparent;  color: #03a9f4;  width: 100%;  border: none;  border-radius: 0;  border-bottom: 1px solid #ddd;}

  input:focus { outline: none; }

  /* Label */
  label {  color: #999;   font-size: 18px;  font-weight: normal;  position: absolute;  pointer-events: none;  left: 5px;  top: 10px;  -webkit-transition:all 0.2s ease;  transition: all 0.2s ease;}

  /* active */

  input:focus ~ label, input.used ~ label {  top: -20px;  -webkit-transform: scale(.75);          transform: scale(.75); left: -2px;  color: #8A2785;}

  /* Underline */
  .bar {  position: relative;  display: block;  width: 100%;}
  .bar:before, .bar:after {  content: '';  height: 2px;   width: 0;  bottom: 1px;   position: absolute;  background: #4a89dc;   -webkit-transition:all 0.2s ease;   transition: all 0.2s ease;}
  .bar:before { left: 50%; }
  .bar:after { right: 50%; }

  /* active */
  input:focus ~ .bar:before, input:focus ~ .bar:after { width: 50%; }

  /* Highlight */
  .highlight {  position: absolute;  height: 60%;   width: 100px;   top: 25%;   left: 0;  pointer-events: none;  opacity: 0.5;}

  /* active */
  input:focus ~ .highlight {  -webkit-animation: inputHighlighter 0.3s ease;          animation: inputHighlighter 0.3s ease;}

  /* Animations */
  @-webkit-keyframes inputHighlighter {
    from { background: #4a89dc; }
    to  { width: 0; background: transparent; }
  }

  @keyframes inputHighlighter {
    from { background: #4a89dc; }
    to  { width: 0; background: transparent; }
  }

  div.background{  position: fixed;    width: 100%;    z-index: -1;    height: 100%;    right: -10%;}
  div.background2 {  position: fixed;    width: 100%;    z-index: -1;    height: 100%;    left: 6%;}
  div.background:before {    content: '';    position: absolute;    top: 0;    right: 0;    width: 80%;    height: 70%;    /* opacity: 0.8; */    background-color: #ff0077;   border-bottom: 30px solid #e6016c;  -webkit-transform-origin: 100% 100%;    -ms-transform-origin: 100% 100%;    transform-origin: 100% 100%;    -webkit-transform: skewX(30deg);    -ms-transform: skewX(30deg);    transform: skewY(30deg);    -webkit-box-sizing: border-box;    -moz-box-sizing: border-box;    box-shadow: 0px 0px 20px #89898a;}
  div.background2:before {    content: '';    position: absolute;    bottom: 0;    left: 0;    width: 50%;    height: 100%;     background-color: #ff0077;   border-right: 50px solid #e6016c;  -webkit-transform-origin: 100% 100%;    -ms-transform-origin: 100% 100%;    transform-origin: 100% 100%;    -webkit-transform: skewX(60deg);    -ms-transform: skewX(60deg);        transform: skewX(60deg);    -webkit-box-sizing: border-box;    -moz-box-sizing: border-box;    box-shadow: 0px 0px 20px #89898a;}
  html, body{   background-size:cover;    margin:0;padding:0;    height:100%;}
  .buttonui {   position: relative;    padding: 8px 45px;    line-height: 30px;    overflow: hidden;    border-width: 0;    outline: none;    border-radius: 2px;    box-shadow: 0 1px 4px rgba(0, 0, 0, .6);    background-color: #ff0077;    color: #ecf0f1;    transition: background-color .3s;}
  .buttonui:before {    content: "";    position: absolute;    top: 50%;    left: 50%;    display: block;    width: 0;    padding-top: 0;    border-radius: 100%;    background-color: rgba(236, 240, 241, .3);    -webkit-transform: translate(-50%, -50%);    -moz-transform: translate(-50%, -50%);    -ms-transform: translate(-50%, -50%);    -o-transform: translate(-50%, -50%);    transform: translate(-50%, -50%);}
  .buttonui span  {    padding: 12px 24px;    font-size:16px;}
  .loginForm {   width: 420px;    margin: 0 auto;    z-index: 99;    display: block;    margin-top: 5%;    background: transparent;    border-radius: .25em .25em .4em .4em;    text-align: center;    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);    color: #fff;}
  /* Ripples container */

  .ripples {  position: absolute;  top: 0;  left: 0;  width: 100%;  height: 100%;  overflow: hidden;  background: transparent;}
  .ripplesCircle {  position: absolute;  top: 50%;  left: 50%;  -webkit-transform: translate(-50%, -50%);          transform: translate(-50%, -50%);  opacity: 0;  width: 0;  height: 0;  border-radius: 50%;  background: rgba(255, 255, 255, 0.25);}
  .ripples.is-active .ripplesCircle {  -webkit-animation: ripples .4s ease-in;          animation: ripples .4s ease-in;}

  /* Ripples animation */

  @-webkit-keyframes ripples {
    0% { opacity: 0; }

    25% { opacity: 1; }

    100% {
      width: 200%;
      padding-bottom: 200%;
      opacity: 0;
    }
  }

  @keyframes ripples {
    0% { opacity: 0; }

    25% { opacity: 1; }

    100% {
      width: 200%;
      padding-bottom: 200%;
      opacity: 0;
    }
  }


  /*  -----------------------------------------------------------  */

  .body-login{
    background-image: url("../img/bg-login.jpg");
    background-size: cover;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    -ms-background-size: cover;
    min-height: 100vh;
  }
  .body-login:before{
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom:0;
    left: 0;
    opacity: 0.5;
    background-color: #8A2785;
  }

  .logo{
    margin-right: 19%;
  }
  .btn-login {
    display: block;
    width: 30%;
    color: #fff;
    float: right;
    background-color: #8A2785;
    margin-right: 3%;
    margin-bottom: 5%;
  }
  .styled-input
  .agile-styled-input-top {
    margin-top: 0;
  }
  .styled-input {
    float: right;
    width: 85%;
    margin: 2em 0 2em 1em;
    position: relative;
    margin-top: 0;
  }
  .contact-form input[type="password"],
  .contact-form input[type="email"],
  .contact-form textarea {
    font-size: 1.3em;
    color: #26272b;
    padding: 1.3em 1em .3em 0em;
    border: 0;
    width: 100%;
    border-bottom: 1px solid #b9b9b9;
    background: none;
    -webkit-appearance: none;
    outline: none;
  }
  .styled-input label {
    padding: 1.5em 0em;
    position: absolute;
    top: 0;
    color: #ccc;
    left: 0;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    transition: all 0.3s;
    pointer-events: none;
    font-weight: 600;
    font-size: 1.2em;
    display: block;
    line-height: 1em;
    letter-spacing: 2px;
  }
  .styled-input input~span,
  .styled-input textarea~span {
    display: block;
    width: 0;
    height: 2px;
    background: #8A2785;
    position: absolute;
    bottom: 0;
    left: 0;
    -webkit-transition: all 0.125s;
    -moz-transition: all 0.125s;
    transition: all 0.125s;
  }
</style>

