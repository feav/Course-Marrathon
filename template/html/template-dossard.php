<style type="text/css">
    img.bg
    {
        position:    absolute;
        width:       100%;
        height:      100%;
        top: 0;
        left: 0;

    }
  /*  @font-face {
        font-family: baron;
        src: url('./res/Baron-Bold.otf') format('truetype');
        font-weight: bold;
        font-style: normal;
    }*/
    div.balloon, .course, .dossard, .name, .categorie, .sexe{
        /*font-family: BaronNeueBold;*/

    }
     div.balloon
    {
        position:    absolute;
        top: 4%;
        left: 12%;
        width: 8.7in;
        height: 7.7in;
        color: white;
    }
    .course{
        position: absolute;
        top: 50px;
        left: 0;
        text-align: center;
        font-size: 45px;
        margin-top:0;
        color: white;
        width: 100%;

    }
    .dossard{
        position: absolute;
        top: 250px;
        left: 0;
        text-align: center;
        font-size: 170px;
        margin-top:0;
        color: #47305e;
        width: 100%;
    }
    .name{
        position: absolute;
        top: 450px;
        left: 0;
        text-align: center;
        font-size: 40px;
        color: #47305e;
        margin-top:0;
        /*font-weight: bold;*/
        width: 100%;
    }
    .categorie{
        position: absolute;
        top: 330px;
        left: 5px;
        text-align: left;
        font-size: 55px;
        margin-top:0;
        /*font-weight: /*bold*/
        width: 100%;
    }
    .sexe{
        position: absolute;
        top: 330px;
        left: 5px;
        text-align: right;
        font-size: 55px;
        margin-top:0;
        width: 100%;
    }


    .site{
        position: absolute;
        top: 650px;
        right:  -50px;
        text-align: left;
        font-size: 15px;
        margin-top:0;
        /*font-weight: bold;*/
        color: white;
        width: 100%;
    }
    .ashtag{
        position: absolute;
        top: 650px;
        left: -50px;
        text-align: right;
        font-size: 15px;
        margin-top:0;
        /*font-weight: bold;*/
        color: white;
        width: 100%;
    }

    img.logo
    {
        position:    absolute;
        width:       250px;
        height:      250px;
        top: 460px;
        left: 300px;

        z-index: 4;

    }
    @page {
       /*size: 7in 9.25in;*/
       /*margin: 0 0 0 0;*/
        /*--background-image: url(./res/bg.png);*/
        /*background-size:cover!important   ;*/
        background-color: gray;
        position: relative;
    }
</style>
<page id="page" backcolor="#fff" orientation="paysage" backtop="0" backbottom="0" backleft="0" backright="0">
    <img class="bg" src="<?php echo WPEVENTMARATHON_DIR.'template/img/dossard.png'?>">
   
    <div class="balloon on-right" >

        <div class="balloon-content" style="position: absolute;padding-top: 0px;">
            <div style="width: 100%;height: 100%;padding: 0;margin: 0;position: relative;">
                <div class="course" style="font-family: Baron-Bold;">COURREUR</div>
                <div class="dossard"  style="font-family: Baron-Bold;">XX</div>
                <div class="categorie" style="font-family: Baron-Bold;">XX</div>
                <div class="sexe" style="font-family: Baron-Bold;">X</div>
                <div class="name" style="font-family: Baron-Bold;">NON IDENTIFIE</div>
                <img class="logo" src="<?php echo WPEVENTMARATHON_DIR.'template/img/logo.png'?>">
            </div>
        </div>
    </div>
        
    <div class="site" style="font-family: Baron-Bold;">LEMEUTERUNNING.FR</div>
    <div class="ashtag" style="font-family: Baron-Bold;">@LAMEUTERUNNINGTEAM</div>
</page>
