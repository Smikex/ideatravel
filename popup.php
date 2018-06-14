<div id="buy-form-popup" class="buy-form-popup">
    <h5>Buy a 1 click</h5>
    <form action="" method="post" class="buy-form">
        <label><span>Your name</span>
            <input type="text" name="name" class="buy-form__item buy-form__item_text">
        </label>
        <label><span>Phone number</span>
            <input type="text" name="tel" class="buy-form__item buy-form__item_text">
        </label>
        <label><span>E-mail address</span>
            <input type="text" name="email" class="buy-form__item buy-form__item_text">
        </label>
        <label class="dates-container"><span class="field-title">Choose the date</span>
            <div>
                <input type="text" name="start-date" id="form-1-start-date" class="datepicker buy-form__item buy-form__item_date">
            </div>
            <div>
                <input type="text" name="end-date" id="form-1-end-date" class="datepicker buy-form__item buy-form__item_date">
            </div>
        </label>
        <button type="submit" class="buy-form__submit">Send</button>
    </form>
</div>

<?php if(false): ?>
<div id="buy-1-click-form-popup" class="buy-1-click-popup">
    <h5>Buy a 1 click</h5>
    <form action="" method="post" class="buy-form">
        <label>
          <span>Your name</span>
          <input type="text" name="name" class="buy-form__item buy-form__item_text">
        </label>
        <label>
          <span>Phone number</span>
          <input type="text" name="tel" class="buy-form__item buy-form__item_text">
        </label>
        <label class="dates-container"><span class="field-title">Choose the date</span>
            <div>
                <input type="text" name="start-date" id="form-2-start-date" class="datepicker buy-form__item buy-form__item_date">
            </div>
            <div>
                <input type="text" name="end-date" id="form-2-end-date" class="datepicker buy-form__item buy-form__item_date">
            </div>
        </label>
        <button type="submit" class="buy-form__submit">Send</button>
    </form>
</div>
<?php endif; ?>

<div id="buy-1-click-form-popup" class="buy-form-popup">
  <h5><?php _e('Buy a single click','theme-text-idea') ?></h5>
  <!--  <form method="post" class="buy-form by_tour_one_click">-->
  <form method="post" class="buy-form">
    <label>
      <span><?php _e('Your name','theme-text-idea') ?></span>
      <input type="text" name="author" class="buy-form__item buy-form__item_text">
    </label>
    <label>
      <span><?php _e('Phone number','theme-text-idea') ?></span>
      <input type="text" name="phone" class="buy-form__item buy-form__item_text">
    </label>
    <label>
      <span><?php _e('E-mail address','theme-text-idea') ?></span>
      <input type="text" name="mail" class="buy-form__item buy-form__item_text">
    </label>

    <?php if ( $dates = get_field('dates', $id) ){?>
      <label class="dates-container"><span class="field-title"><?php _e('Choose the date','theme-text-idea') ?></span>
        <select class="buy-form-dates" name="date">
          <option value="other"><?php _e('Other','theme-text-idea') ?></option>
          <?php

          $new_arrey = array_map(function ($d) {
            return date('d.m.y', strtotime($d['start'])) . ' - ' . date('d.m.y', strtotime($d['end']));
          }, $dates);

          usort($new_arrey, function($a, $b){
            preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $a, $new_a);
            preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $b, $new_b);

            $a_date = DateTime::createFromFormat('d.m.y', $new_a[0]);
            $b_date = DateTime::createFromFormat('d.m.y', $new_b[0]);

            if($a_date == $b_date) {
              return 0;
            }
            return ($a_date < $b_date) ? -1 : 1;
          });

          $curent_date = new DateTime('NOW');
          foreach ($new_arrey as $date) {
            preg_match('/^\d{1,2}.\d{1,2}.\d{2,4}/', $date, $a);
            preg_match('/\d{1,2}.\d{1,2}.\d{2,4}$/', $date, $b);

            if (DateTime::createFromFormat('d.m.y', $a[0]) < $curent_date || DateTime::createFromFormat('d.m.y', $b[0]) < $curent_date) {
              echo '<option disabled>' . $date . '</option>';
            } else {
              echo '<option>' . $date . '</option>';
            }
          }
          ?>
        </select>
      </label>
    <?php } ?>

    <button type="submit" class="buy-form__submit"><?php _e('Send','theme-text-idea') ?></button>
    <input type="hidden" name="postid" value="">
  </form>
</div>

<div id="buy-ticket-popup" class="buy-form-popup">
    <h5><?php _e('Buy ticket','theme-text-idea') ?></h5>
    <form method="post" class="buy-form">
        <input type="hidden" name="postid">
        <label>
          <span><?php _e('Your name','theme-text-idea') ?></span>
          <input type="text" name="author" class="buy-form__item buy-form__item_text">
        </label>
        <label>
          <span><?php _e('Phone number','theme-text-idea') ?></span>
          <input type="text" name="phone" class="buy-form__item buy-form__item_text">
        </label>
        <label>
          <span><?php _e('E-mail address','theme-text-idea') ?></span>
          <input type="text" name="mail" class="buy-form__item buy-form__item_text">
        </label>
        <button type="submit" class="buy-form__submit"><?php _e('Send','theme-text-idea') ?></button>
    </form>
</div>

<div id="gratitude-popup" class="gratitude-popup">
    <h5>Thank you</h5>
    <p></p>
</div>
