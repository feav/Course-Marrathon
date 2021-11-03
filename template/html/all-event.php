<?php
    $wpEventMarathon = new WpEventMarathon();
    
    $args = array(
            'post_type' => $this->post_type_event['post_type'],
            'posts_per_page' => -1
        );
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) : 
            ?> 
        <div>
           <main >
              <div  style="width: 100%;max-width: inherit;">
                <?php
                while ( $query->have_posts() ) : $query->the_post(); 
                    $global_id = get_the_ID();

                    $date_sub = get_post_meta( $global_id, 'date_end_subscribe', true );
                    $time_sub = get_post_field(  $global_id,'time_end_', true );
                    $date_com_sub = date("Y-m-d H:I", strtotime($date_sub.' '.$time_sub) );
                    $diff = human_time_diff( strtotime(date("Y-m-d H:I")), strtotime($date_sub.' '.$time_sub) );
                    $in_future_inscription = true;
                    if(strtotime(date("Y-m-d H:I")) >= strtotime($date_sub.' '.$time_sub) )
                        $in_future_inscription = false;


                    $date_sub = get_post_meta( $global_id, 'date_end_', true );
                    $time_sub = get_post_field(  $global_id,'time_end_', true );
                    $date_com_sub = date("Y-m-d H:I", strtotime($date_sub.' '.$time_sub) );
                    // var_dump(strtotime($date_sub.' '.$time_sub));
                    if(isset($_GET['debbug'])){
                        echo $date_com_sub;
                        echo '-';
                        echo date("Y-m-d H:I") ;
                        echo '-'.($date_sub.' '.$time_sub);
                    }
                    $diff = human_time_diff( strtotime(date("Y-m-d H:I")), strtotime($date_sub.' '.$time_sub) );
                    $in_future = true;
                    if(strtotime(date("Y-m-d H:I")) >= strtotime($date_sub.' '.$time_sub) )
                        $in_future = false;
                    $LINK = get_the_permalink();
                ?>
                <?php if($in_future): ?>
                    <a href="<?php echo get_the_post_thumbnail_url($global_id );?>"><?php echo get_the_title($global_id );?></a> 
                        <ul style="margin: 0;padding: 0 15px;color: black;min-height: 50px;">
                            <?php $distances = $wpEventMarathon->get_itineraire_of_course_basique(get_the_ID()); ?>
                                <?php foreach ($distances as $key => $value): ?>
                            <li><a href="<?php echo get_the_permalink($value['id']) ?>" style="color: black;"><?php echo get_post_meta($value['id'],'distance',true) ?></a></li>
                    <?php endforeach ?>
                                </ul>
                <?php endif; 

                    endwhile; 
                    ?>


                </div>

           </main>
        </div>


             <?php
    else:
        $i=0;
    endif; 
    wp_reset_postdata();
?>

<style type="text/css">
    /* defined global color theme */
        :root {
          --primary-color: rgb(0,150,136); /* color */
          --secondary-color: rgb(0,150,136);/* black */
          --tertiary-color: rgb(0,150,136);
        }
    .mdl-grid {
        max-width: 600px;
    }
    .mdl-card__media {
        margin: 0;
    }
    .mdl-card__media  img {
        width: 100%;
        max-width: 100%;
        height: 200px;
        object-fit: cover;
        object-position: center;
    }
    .mdl-card__actions {
        display: flex;
        box-sizing:border-box;
        align-items: center;
    }
    .mdl-card__actions > .mdl-button--icon {
        margin-right: 3px;
        margin-left: 3px;
    }
    .mdl-color--grey-100 {
        background-color: #ffffff !important;
    }
    .content-area {
        width: 100%;
    }
    .heading-prop-2 h1 {
        font-size: 1.5em;
    }
    .mdl-card__supporting-text {
        padding: 0 16px;
    }
    .mdl-card.mdl-cell:hover{
     transform: scale(1.02);
      box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
    }
    .mdl-card.mdl-cell{
          transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
      cursor: pointer;
    }
    .text-2-lines,.uncode_text_column{
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    p.text-2-lines {
        margin: 0 0 5px;
    }
    }
    .mdl-card__supporting-text {
        padding: 0 16px;
        width: 100%;
    }
    .mdl-card__title-text a{
        text-decoration: none;
        color: black;
    }
    .mdl-card__media {
        background-color: rgb(0 0 0);
    }
    span.closure {
        position: absolute;
        top: 0;
        right: 0;
        border: 1px solid black;
        border-radius: 20px;
        padding: 2px 10px;
        margin: 5px 10px;
        background: white;
    }
    .mdl-card__supporting-text > p {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>   

