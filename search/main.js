function renderType(type,ele){
    return `<div class="resultCard">
    <div class="resultType type${type}">${type}</div>
    <div class="marker"></div>
    <div class="resultCardInfo">
        <div class="authorImgWrapper">
            <img class="authorImg" src="../assets/img/iconfinder_batman_hero_avatar_comics_4043232.png" alt="">
        </div>
        <div class="authorInfoWrapper">
            <div class="authorName">
                <a href="#">${ele.authorName}</a>
            </div>
            ${ele.type !== 'User' ? `<div class="authorCreated">${ele.authorCreated}</div>` :''}
        </div>
    </div>
    <div class="resultCardDetails">
        <div class="resultCardTitle">
            <a class="resultCardTitleLink" href="#">${ele.title}</a>
        </div>
        ${ele.hasOwnProperty('tags') ? `
            <ul class="resultCardTags">
                ${ele.tags.reduce((res,cur)=>{
                    return res+ `<li class="cardTag"><a href="#">${cur}</a></li>`;
                },'')}
            </ul>
        `:''}
        ${ele.hasOwnProperty('description') ? `<div class="resultCardDes">${ele.description}</div>`:''}
        ${ele.hasOwnProperty('view')? `<div class="resultCardView">View: ${ele.view}</div>`:''}
    </div>
</div>`
}


function render(data){
    let dataHTML = data.reduce((res,cur)=>{
        switch(cur['type']){
            case 'Post':
                return res + renderType('Post',cur);
            case 'Comment':
                return res +renderType('Comment',cur);
            case 'User':
                return res +renderType('User',cur);
            default:
                break;
        }
    },'');
    document.getElementsByClassName('searchResult')[0].innerHTML= dataHTML;
}

function filterType(e,type){
    let filType = document.getElementsByClassName('filterType');
    for(let ele of filType){
        ele.classList.remove('active');
    }
    e.target.classList.add('active');
    if(type ==='All'){
        filtedTypeData = data.slice();
    }
    else{
        filtedTypeData = data.filter((fil)=>{
            return fil['type'] === type;
        });
    }
    document.getElementById('filTagAll').click();
    document.getElementById('sortRelevant').click();
}
function filterTag(e,tag){
    let filTag = document.getElementsByClassName('filterTag');
    for(let ele of filTag){
        ele.classList.remove('active');
    }
    e.target.classList.add('active');
    if(tag === 'All'){
        filtedTagData = filtedTypeData.slice();
    }
    else{
        filtedTagData = filtedTypeData.filter((fil)=>{
            if(fil.hasOwnProperty('tags')){
                return fil['tags'].indexOf(tag) > 0;
            }
        });
    }
    document.getElementById('sortRelevant').click();
}

function sort(e,compareFunc){
    let sorts = document.getElementsByClassName('sort');
    for(let ele of sorts){
        ele.classList.remove('active');
    }
    e.target.classList.add('active');
    let dataSorted = filtedTagData.sort(compareFunc);
    console.log(dataSorted);
    render(dataSorted);
}

function sortName(e){
    function comparF(a,b){
        if(a['title'] < b['title']) return -1;
        if(a['title'] > b['title']) return 1;
        return 0;
    }
    sort(e,comparF);
}
function sortView(e){
    function compareF(a,b){
        if(!b.hasOwnProperty('view')) return -1;
        return - a['view'] + b['view'];
    }
    sort(e,compareF);
}

function sortRelevant(e){
    function compareF(a,b){
        return a['id'] - b['id'];
    }
    sort(e,compareF);
}

function sortNew(e){
    function compareF(a,b){
        if(!b.hasOwnProperty('authorCreated')) return -1;
        return - a['authorCreated'] + b['authorCreated'];
    }
    sort(e,compareF);
}


window.addEventListener('load',()=>{
    //sort
    const sortNewestEle = document.getElementById('sortNew');
    const sortViewEle = document.getElementById('sortView');
    const sortNameEle = document.getElementById('sortName');
    const sortRelevantEle = document.getElementById('sortRelevant');
    
    sortNewestEle.addEventListener('click',sortNew);
    sortViewEle.addEventListener('click',sortView);
    sortNameEle.addEventListener('click',sortName);
    sortRelevantEle.addEventListener('click',sortRelevant);
    //fil
    document.getElementById('filTypeAll').addEventListener('click',(e)=>filterType(e,'All'));
    document.getElementById('filPost').addEventListener('click',(e)=>filterType(e,'Post'));
    document.getElementById('filComment').addEventListener('click',(e)=>filterType(e,'Comment'));
    document.getElementById('filUser').addEventListener('click',(e)=>filterType(e,'User'));
    document.getElementById('filTagAll').addEventListener('click',(e)=>filterTag(e,'All'));
    document.getElementById('filSocial').addEventListener('click',(e)=>filterTag(e,'Social'));
    document.getElementById('filNews').addEventListener('click',(e)=>filterTag(e,'News'));
    document.getElementById('filArt').addEventListener('click',(e)=>filterTag(e,'Art'));
    document.getElementById('filTech').addEventListener('click',(e)=>filterTag(e,'Tech'));
    document.getElementById('filScience').addEventListener('click',(e)=>filterTag(e,'Science'));
    document.getElementById('filBiology').addEventListener('click',(e)=>filterTag(e,'Biology'));
    document.getElementById('filMechanic').addEventListener('click',(e)=>filterTag(e,'Mechanic'));
    render(filtedTypeData);
})


// data
const data = [
    {
        'id':1,
        "type":"Post",
        "authorName":"ethank99",
        "authorCreated":2020,
        "title":"MongoDB Architecture",
        "tags":[
            'Tech',
            "Social",
            "News"
        ],
        "description":"MongoDB is a source-available cross-platform document-oriented database program",
        "view":3152
    },
    {
        'id':2,
        "type":"Comment",
        "authorName":"depzai13",
        "authorCreated":2019,
        "title":"PhP Introduction",
        "tags":[
            'Tech'
        ],
        "description":"I have never learnt it",
    },
    {
        'id':3,
        "type":"User",
        "authorName":"son124",
        "title":"Son Of Code",
    },{
        'id':4,
        "type": "User",
        "authorName": "Tonia",
        "title":"Tibu the one",
    },{
        'id':5,
        "type": "Comment",
        "authorName": "Nessie",
        "authorCreated": 2014,
        "tags": [
            "Mechanic",
            "News",
            "Social",
            "Tech",
            "Science"
        ],
        "title": "Meter Guayaquil",
        "description": "Nice to meet you and wish to you",
    },{
        'id':6,
        "type": "Post",
        "authorName": "Adelle",
        "authorCreated": 2020,
        "tags": [
            "Social",
            "Biology",
            "Tech"
        ],
        "title": "Erich Dibrugarh",
        "description": "this is a dump description , end",
        "view": 9361
    },{
        'id':7,
        "type": "Post",
        "authorName": "Coral",
        "authorCreated": 2015,
        "tags": [
            "Tech",
            "Science",
            "Social",
            "News"
        ],
        "title": "Hourigan Brasília",
        "description": "The last text of this sentence is end",
        "view": 192
    },{
        'id':8,
        "type": "Post",
        "authorName": "Janeczka",
        "authorCreated": 2010,
        "tags": [
            "Nature",
            "News",
            "Mechanic",
            "Biology"
        ],
        "title": "Suk Belmopan",
        "description": "sentence description hello description sentence best two work example two one two work best one work test two one sentence best example test sentence best hello work example hello one sentence two test description one work two work two one example example test two description test one sentence hello one best test description description sentence best example hello best sentence test two test  to you",
        "view": 9866
    },{
        'id':9,
        "type": "Post",
        "authorName": "Violet",
        "authorCreated": 2017,
        "tags": [
            "Art",
            "Social",
            "Science",
            "Art",
            "Mechanic"
        ],
        "title": "Sabella Asunción",
        "description": "one one description test best description test test one test description one sentence two work description description one two test work description description example sentence test hello description hello hello best description one work example example one one description best best best best one  to you",
        "view": 5442
    },{
        'id':10,
        "type": "Comment",
        "authorName": "Bernie",
        "authorCreated": 2010,
        "tags": [
            "Biology",
            "News",
            "Science",
            "Social"
        ],
        "title": "Ephrem Guadalajara",
        "description": "two sentence test one hello work example sentence one description  end"
    },{
        'id':11,
        "type": "User",
        "authorName": "Madelle",
        "title": "Bari Invercargill",
    },{
        'id':12,
        "type": "Comment",
        "authorName": "Althea",
        "authorCreated": 2021,
        "tags": [
            "Mechanic",
            "Art",
            "News",
            "Science",
            "Tech",
            "Social"
        ],
        "title": "Jammal City of San Marino",
        "description": "best hello best hello work work description one description work one sentence description sentence best work best hello sentence description test work test one hello test test one two test description sentence best description description best one example one description example work two best best one work example sentence  to you"
    },{
        'id':13,
        "type": "Comment",
        "authorName": "Joy",
        "authorCreated": 2011,
        "tags": [
            "Biology",
            "Art",
            "Mechanic",
            "Tech",
            "Science"
        ],
        "title": "Cleo Semarang",
        "description": "hello test description best hello one two sentence description test one example test hello one hello description best sentence sentence sentence best sentence hello example description two example sentence example one one test work sentence one work sentence hello test sentence hello test example example hello hello two example hello hello one description sentence one one description two one hello test one example test sentence work sentence test work two one best two hello two sentence test work description description work one example best  end"
    },{
        'id':14,
        "type": "Post",
        "authorName": "Ivett",
        "authorCreated": 2020,
        "tags": [
            "News",
            "Nature",
            "Mechanic",
            "Social",
        ],
        "title": "Alarise Nouakchott",
        "description": "description test two best two two sentence best example one best sentence example two best description description example example best two two one description two one two work best work description work work two example work hello description hello test hello description work sentence work two two description sentence best  to you",
        "view": 9567
    },{
        'id':15,
        "type": "User",
        "authorName": "Alexine",
        "title": "Wesle Nouméa",
        "description": "example one work work work hello sentence work sentence best two best sentence work work best two two example two test two hello work one best work description sentence sentence example work  end"
    }
];
var filtedTypeData = data.slice();
var filtedTagData = filtedTypeData.slice();

//random template 
// {
    //     "type": choice('Post', 'Comment', 'User'),
    //     "authorName": firstname(),
    //     "authorCreated": random(2010, 2021),
    //     "array": repeat(6, choice('Social', 'Tech', 'News','Biology','Science','Art','Nature','Mechanic')),
    //     'lname':lastname(),
    //     'city':city(),
    //     "title": function () {
        //         return this.lname + ' ' + this.city;
        //     },
//     "description": regex(/\w{10,100} (end|to you)/),
//       "view":random(100,10000),
    
//   }
  
  