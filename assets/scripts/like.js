import axios from 'axios';

export default class Like {
    constructor(likeElements) {
        this.likeElements = likeElements;

        if(this.likeElements) {
            this.init();
        }
    }

    init() {
        this.likeElements.map(element => {
            element.addEventListener('click' , this.onClick);
        })
    }
    
    onClick(event) {
        event.preventDefault();
        const url = this.href;

        axios.get(url).then(res => {
            console.log(res, this);
            const nb = res.data.nbLike;
            const span = this.querySelector('span');

            this.dataset.nb = nb;
            span.innerHTML = nb + ' J\'aime';

            const thumbsFaUpLight = this.querySelector('i.fa-regular');
            const thumbsFaUpSolid = this.querySelector('i.fa-solid');

            thumbsFaUpLight.classList.toggle('hidden');
            thumbsFaUpSolid.classList.toggle('hidden');


        })

    }
}