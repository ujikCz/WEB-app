<? if(!defined("GLOBAL")) return; ?>

<?=block::board()?>
<?=block::aside()?>
<?=block::contextMenu()?>

<script type="text/javascript">
// just for test
const userID = 2;
async function login() {
  //const data = await callAPI("login","login=jan&password=hello");
  await callAPI("login","login=dc&password=bar");
}
login();
// end of test

</script>
