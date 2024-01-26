<?php
    echo 'dddd'
?>
<script>

const apiUrl = 'https://www.technicalpariwar.com/testapi';

fetch(apiUrl)
  .then(response => {
    if (!response.ok) {
      throw Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    console.log(data);
  })
  .catch(error => {
    console.error('There was a problem with the fetch operation:', error);
  });

</script>