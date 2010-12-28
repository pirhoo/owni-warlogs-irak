<script type="text/javascript">
    <?php if( isset($_GET["fail"]) ) { ?>
            showPopup("<?php echo getTrad(49); ?>");
    <?php } ?>
        


    $(document).ready( function () {
        $(".triggerIndesir").click(function ()  {
                var parent = $(this).parent().parent(".admin-comm");
                if( ! $(parent).hasClass("indesirable") ) {
                    $(parent).addClass("indesirable");
                    $(parent).removeClass("desirable").removeClass("attente");

                    $.ajax({ url: "./xhr/comment-statut.php",
                            type: "GET",
                            data : "statut=-1&ID=" + $(".comm-ID", parent).html(),
                            context: document.body
                         });
                }
        });

        $(".triggerDesir").click(function ()  {
                var parent = $(this).parent().parent(".admin-comm");
                if( ! $(parent).hasClass("desirable") ) {
                    $(parent).addClass("desirable");
                    $(parent).removeClass("indesirable").removeClass("attente");

                    $.ajax({ url: "./xhr/comment-statut.php",
                            type: "GET",
                            data : "statut=1&ID=" + $(".comm-ID", parent).html(),
                            context: document.body
                         });
                }
        });


        $(".triggerAttente").click(function ()  {
                var parent = $(this).parent().parent(".admin-comm");
                if( ! $(parent).hasClass("attente") ) {
                    $(parent).addClass("attente");
                    $(parent).removeClass("indesirable").removeClass("desirable");

                    $.ajax({ url: "./xhr/comment-statut.php",
                            type: "GET",
                            data : "statut=0&ID=" + $(".comm-ID", parent).html(),
                            context: document.body
                         });
                }
        });
    });
</script>

<h3 class="rapportTitle">Administration</h3>
<div class="main-content">
    <?php if(is_logged()) : ?>
        <h4 id="comments"><?php echo getTrad(50); ?></h4>
    <?php else: ?>
        <h4><?php echo getTrad(48); ?></h4>
    <?php endif; ?>

    <?php if(! is_logged() ): ?>
        <form action="admin.php" method="POST" class="authentification">
            <input type="hidden" name="lang" value="<?php echo LANG; ?>" />
            <label>
                <?php echo getTrad(46); ?> : <br />
                <input type="text" class="text" name="pseudo" />
            </label>

            <label>
                <?php echo getTrad(47); ?> : <br />
                <input type="password" class="text" name="mdp" />
            </label>

            <input type="submit" class="submit" value="<?php echo getTrad(48); ?>" />
            <br style="clear:right;"/>
        </form>
    <?php else:

        $query  = "SELECT * FROM war_contrib ";
        $query .= "ORDER BY Date DESC ";

        if(!$db_wikileaks->query($query));
            echo $db_wikileaks->getErr_query();

        $i = 0; ?>
        <div class="comments segment">
            <?php while($contrib = $db_wikileaks->fo()): ?>

                <div class="
                            admin-comm
                            <?php echo ($i++%2 == 0) ? 'pair' : 'impair'; ?>
                            <?php echo ($contrib->Visible == 0) ? 'attente' : ( ($contrib->Visible == 1) ? 'desirable' : 'indesirable' ); ?>
                          ">

                        <a class="seeLog" href="index.php?ecran=2&lang=<?php echo LANG; ?>&key=<?php echo $contrib->ReportKey; ?>"><?php echo getTrad(56); ?></a>
                        <span class='name'><abbr title='<?php echo easyTime($contrib->Date); ?>'><a href="mailto:<?php echo $contrib->Email; ?>"><?php echo $contrib->Name; ?></a></abbr> <?php echo getTrad(36); ?> :</span>

                        <p class='content'><?php echo nl2br($contrib->Content); ?></p>
                        <p class="moderation"><?php echo getTrad(54); ?> : <span style="color:#3b753b" class="triggerDesir"><?php echo getTrad(51); ?></span> | <span style="color:#a80000" class="triggerIndesir"><?php echo getTrad(52); ?></span> | <span class="triggerAttente"><?php echo getTrad(53); ?></span></p>
                        <span class="comm-ID" style="display:none"><?php echo $contrib->ID; ?></span>
                </div>

            <?php endwhile; ?>
        </div>
        <h4 id="add-article"><?php echo getTrad(59); ?></h4>
        <div class="segment"></div>
</div>
    <?php
        
endif; ?>