<style>
body{
    font-family: "Source Sans Pro", "Segoe UI", Frutiger, "Frutiger Linotype", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
    background: url('<?= asset('img/blue.jpg') ?>') no-repeat center center/cover;
    text-align: center;
    color: #fff;
    margin: 0;
    position: relative;
}

div, input{
    box-sizing: border-box;
}

.authentication-logo{
    margin: 0 auto; 
    width: 100%;
    text-align: center; 
    padding-top: 180px;
}

.authentication-logo img{
    width: 80px;
    margin: 0 auto !important;
}

.authentication-logo h1{
    color: #0c59a2;
    margin-top: -8px;
}

.authentication-logo h1 span{
    color: #fff;
}

.content{
    width: 480px;
    padding: 30px 30px 50px;
    background: rgba(0,0,0,.26);
    box-shadow: 1px 1px 2px rgba(169,169,169,.44);
    margin: 0 auto;
    max-width: 100%;
}

.content h2{
    font-size: 18px;
    font-weight: 500;
    margin: 0 auto 20px;
}

.form-input{
    background-color: white;
    font-family: inherit;
    border: 1px solid #dfdfdf;
    color: #000;
    display: block;
    font-size: 14px;
    margin: 0 0 13px 0;
    padding: 7px 15px;
    height: 50px;
    width: 100%;
}

.form-group{
    margin-top: 10px;
}

button.flat{
    width: 100%;
    background: #36bae2;
    box-shadow: none;
    color: #fff;
    font-weight: 500;
    cursor: pointer;
    position: relative;
    display: inline-block;
    font-size: 14px !important;
    margin: 0;
    padding: 12px;
    position: relative;
    text-align: center;
    border-radius: 2px;
    border: none;
}

button.flat:hover{
    background-color: #1da0c8;
}

.links-small{
    margin: 10px auto 0;
}

.links-small a{
    color: #d3d1d1;
    font-size: 14px;
    font-weight: 100;
}

.links-small a:hover{
    text-decoration: none;
}

.invalid-feedback{
    color: #ff8e8b;;
    font-size: 14px !important;
    line-height: 19px;
    font-weight: 500;
}

.copyright{
    text-align: center;
    color: #ddd;
    font-size: 14px;
    font-weight: normal;
    padding: 30px 0 40px;
}
</style>