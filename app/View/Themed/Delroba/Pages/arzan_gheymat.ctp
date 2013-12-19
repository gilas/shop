<?php
$this->Html->addCrumb('طرح ساماندهی اسکان زائرین');
$this->set('title_for_layout', 'طرح ساماندهی اسکان زائرین');
?>
<h2>طرح ساماندهی اسکان زائرین</h2>
<p>از آنجا که یکی از مشکلات اساسی و دغدغه های اصلی زائرین به ویژه اقشار متوسط و کم برخوردار که بخش عمده زائرین را تشکیل می دهند، مسئله اقامت می باشد و این امر مسئولین استانی و شهری را بر آن داشت تا از محل بودجه زیارت اقدام به ایجاد زائرسراهای ارزان قیمت نمایند و جانمایی و اقدام برای ایجاد 14 زائرسرا به نام چهارده معصوم از جمله این تصمیمات می باشد. لذا برنامه ریزی جهت رفع این مشکل و کمبود از اولویت های اول ستاد ساماندهی امور زائرین و مدیریت یکپارچه زائر است. به همین خاطر علاوه بر برنامه ریزی جهت استفاده از حدود سیصد هزار تخت موجود در واحدهای اقامتی مشهد، تسهیلات و تمهیدات لازم برای ایجاد شصت هزار تخت اقامتگاه ارزان قیمت را در دستور کار خود قرار داده است که با مشارکت و همکاری فرمانداری ، شهرداری ، سازمان اوقاف و امور خیریه ، سازمان میراث فرهنگی و گردشگری و سایر بخش های مرتبط و بخش خصوصی در دست اقدام می باشد.</p>
<p>در این راستا بسته های سفر ارزان قیمت با تنوع زیاد از جهت مدت اقامت و درجه خدمات اقامتی و سایر خدمات برای تمامی سطوح و اقشار و طبقات جامعه با اولویت سفرهای گروهی و برای ایام غیر پیک و ادارات و سازمان ها ، مدارس ، مراکز دانشگاهی، مراکز تولیدی و خدماتی بزرگ، مساجد و حسینیه ها، بقاء اماکن متبرکه و هیأت مذهبی و دسته جات و گروه ها و جلسات مذهبی و دینی در نظر گرفته شده است که علاقه مندان می توانند به صورت مستقیم از طریق این سامانه و یا غیر مستقیم از طریق دفاتر خدمات پستی و پیشخوان دولت در سراسر کشور ثبت نام و اقدام نمایند.</p>
<p>بسته های سفر ارزان قیمت از نظر درجه و کیفیت به 24 سطح تقسیم شده است که پایین ترین آن سطح یک بوده و خدمات آن اقامت در کمپ و حسینیه و اردوگاه&nbsp; و ... می باشد و بالاترین آن سطح 24 بوده که خدمات آن معادل هتل 5 ستاره می باشد. نرخ اقامت در تمام مدت ثابت بوده و هیچ گونه افزایش نرخی نخواهیم داشت. همچنین علاوه بر تخفیف 10 تا 50 درصدی از نرخ های مصوب اتحادیه و سازمان میراث فرهنگی و گردشگری در سال جاری برای تمامی بسته های ارائه شده ، برای آن دسته از هموطنان عزیز که بسته های شماره 4 به بعد و از سطح 3 به بعد را انتخاب می نمایند امکان پرداخت اقساطی بدون هیچ گونه افزایش نرخی نیز فراهم شده است.</p>
<p>بدین امید که توانسته باشیم رضایت خاطر شما عزیزان را فراهم نمائیم. شما را به انتخاب بسته مورد نظرتان در صفحه <a href="<?php echo $this->Html->url('/eskan/showNerkh') ?>">مشاهده نرخ</a> دعوت می نمائیم.</p>
    <h2> میزان تخفیف داده شده در بسته های سفر طرح ساماندهی اسکان زائرین :</h2>
    <table class="users">
        <tr>
            <th></th><th>بسته شماره 1</th><th>بسته شماره 2</th><th>بسته شماره 3</th><th>بسته شماره 4</th><th>بسته شماره 5</th><th>بسته شماره 6</th><th>بسته شماره 7</th>
        </tr>
        <tr>
            <th>میزان تخفیف ایام پیک :</th>
            <td>% 10</td>
            <td>% 15</td>
            <td>% 20</td>
            <td>% 25</td>
            <td>% 30</td>
            <td>% 30</td>
            <td>% 30</td>
            
        </tr>
        <tr>
            <th>میزان تخفیف ایام غیر پیک :</th>
            <td>% 20</td>
            <td>% 25</td>
            <td>% 30</td>
            <td>% 35</td>
            <td>% 40</td>
            <td>% 45</td>
            <td>% 50</td>
        </tr>
    </table>
           <h2> به عنوان مثال</h2>
        <p>
        هزینه یک واحد اقامتی با شبی ده هزار تومان پس از اعمال تخفیف در هر یک از بسته های هفت گانه به شرح ذیل خواهد شد.
        </p>
        <?php
    $m = 10000 ;
    $p10 = $m - ($m * 10 / 100);
    $p15 = $m - ($m * 15 / 100);
    $p20 = $m - ($m * 20 / 100);
    $p25 = $m - ($m * 25 / 100);
    $p30 = $m - ($m * 30 / 100);
    $p35 = $m - ($m * 35 / 100);
    $p40 = $m - ($m * 40 / 100);
    $p45 = $m - ($m * 45 / 100);
    $p50 = $m - ($m * 50 / 100);
        ?>
    <table class="users">
        <tr>
            <th></th><th>بسته شماره 1</th><th>بسته شماره 2</th><th>بسته شماره 3</th><th>بسته شماره 4</th><th>بسته شماره 5</th><th>بسته شماره 6</th><th>بسته شماره 7</th>
        </tr>
        <tr>
            <th>میزان تخفیف ایام پیک :</th>
            <td><?php echo $this->Html->price($p10); ?></td>
            <td><?php echo $this->Html->price($p15); ?></td>
            <td><?php echo $this->Html->price($p20); ?></td>
            <td><?php echo $this->Html->price($p25); ?></td>
            <td><?php echo $this->Html->price($p30); ?></td>
            <td><?php echo $this->Html->price($p30); ?></td>
            <td><?php echo $this->Html->price($p30); ?></td>
        </tr>
        <tr>
            <th>میزان تخفیف ایام غیر پیک :</th>
            <td><?php echo $this->Html->price($p20); ?></td>
            <td><?php echo $this->Html->price($p25); ?></td>
            <td><?php echo $this->Html->price($p30); ?></td>
            <td><?php echo $this->Html->price($p35); ?></td>
            <td><?php echo $this->Html->price($p40); ?></td>
            <td><?php echo $this->Html->price($p45); ?></td>
            <td><?php echo $this->Html->price($p50); ?></td>
        </tr>
    </table>
<p style="text-align: center"><?php echo $this->Html->link('مشاهده نرخ','/eskan/showNerkh',array('class' => 'btn')); ?></p>