<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>E-Mail</title>

  <script src='https://www.google.com/recaptcha/api.js?hl=en'></script>

</head>
<body>

    <form id="form1" name="form1"  method="post" action="<?=base_url(); ?>/send_mail">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" class="form-control" name="name"id="name"> 
            </div>
          </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input type="email" class="form-control" name="email" id="email">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <input type="text" class="form-control" name="phone" id="phone">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <textarea class="form-control" rows="10" name="message" id="comment"></textarea>
            </div>
          </div>
        </div>

        <div class="g-recaptcha" data-sitekey="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"></div><br>
        <button type="submit">Send</button>
      </form>
      
</body>
</html>

