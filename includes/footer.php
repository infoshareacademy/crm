        </div>
        <!--end #tab-content-->
    </main>
</div>
<!-- end wrapper-->

<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>

</body>

</html><?php

$content = ob_get_contents();
$length = strlen($content);
header('Content-Length: '.$length);
//echo $content;
        ?>