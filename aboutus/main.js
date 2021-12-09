window.addEventListener('load',()=>{
    const btnleft = document.getElementsByClassName('btn-container')[0];
    const btnright = document.getElementsByClassName('btn-container')[1];
    const imgs = document.getElementsByClassName('image-slider');
    const lis = document.getElementsByTagName('li');
    var count = 0;
    const slider = document.getElementsByClassName('slider')[0];
    
    
    
    let str ='';
        for(let i = 0;i<imgs.length;i++){
            str +="<li></li>";
        }
        slider.innerHTML = str;

    change(imgs,count,'display');
    change(lis,count,'check');
    setInterval(()=>{
        count++;
        if(count > imgs.length-1){
            count = 0;
            console.log('max');
        }
        change(imgs,count,'display');
        change(lis,count,'check');
    },4000);
    //function
    btnleft.addEventListener('click',(e)=>{
        count--;
        if(count<0){
            count = imgs.length-1;
            console.log('am');
        }
        change(imgs,count,'display');
        change(lis,count,'check');
    })
    btnright.addEventListener('click',(e)=>{
        count++;
        if(count > imgs.length-1){
            count = 0;
            console.log('max');
        }
        change(imgs,count,'display');
        change(lis,count,'check');
    })
    function change(arr,index,classname){
        for(let i of arr){
            i.classList.remove(classname);
        }
        console.log(index);
        arr[index].classList.add(classname);
    }

})
