<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ title }} <span class="badge badge-success">{{ categoryName }}</span></div>

                    <div class="card-body text-center drill-body">
                        <button type="button" class="btn btn-secondary" @click="backMove">BACK</button>
                        <button class="btn btn-primary " @click="doDrill" v-if="!isStarted">START</button>
                        <p v-if="isCountDown" style="font-size: 100px;">{{ countDownNum }}</p>

                        <template v-if="isStarted && !isCountDown && !isEnd">
                            <p>{{ timerNum }}</p>
                            <span v-for="(word, index) in problemWords" :key=index :class="{'text-primary': index < currentWordNum}">{{word}}</span>
                        </template>

                        <template v-if="isEnd">
                            <p>あなたのスコア</p>
                            <p>{{ typingScore }}</p>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import keyCodeMap from '../master/keymap'

    export default {
        props:['title', 'problem', 'categoryName'],
        data: function() {
            return {
                countDownNum: 3,    //開始前のカウントダウン用
                timerNum: 30,        //ゲーム時間
                missNum: 0,         //ミスした回数
                wpm: 0,             //words per minute(1分あたりによめる単語量)
                isStarted: false,
                isEnd: false,
                isCountDown: false,
                currentWordNum: 0,  //現在回答中の文字数目
                currentProblemNum: 0,   //現在の問題番号
            }
        },
        computed: {
            //問題テキスト
            problemText: function() {
                return this.problem['problem' + this.currentProblemNum]
            },
            //問題テキスト(配列形式)
            problemWords: function() {
                return Array.from(this.problem[this.currentProblemNum])
            },
            //問題の解答キーコード
            problemKeyCodes: function() {
                if (!Array.from(this.problem[this.currentProblemNum]).length) {
                    return null
                }

                //テキストから問題のキーコード配列を生成
                let problemKeyCodes = []
                console.log(Array.from(this.problem[this.currentProblemNum]))
                Array.from(this.problem[this.currentProblemNum]).forEach((text) => {
                    $.each(keyCodeMap, (keyText, keyCode) => {
                        if (text === keyText) {
                            problemKeyCodes.push(keyCode);
                        }
                    })
                })
                console.log(problemKeyCodes)
                return problemKeyCodes
            },
            //問題の文字数
            totalWordNum: function() {
                return this.problemKeyCodes.length
            },
            //タイピングスコア
            typingScore: function() {
                return (this.wpm * 2) * (1- this.missNum / (this.wpm * 2))
            }
        },
        methods: {
            doDrill: function() {
                this.isStarted = true
                this.countDown()
            },
            countDown: function() {
                //効果音読み取り
                const countSound = new Audio('../sounds/Countdown03-6.mp3')
                const startSound = new Audio('../sounds/Timer01-2(30_Seconds).mp3')

                this.isCountDown = true
                this.soundPlay(countSound)
                
                let timer = window.setInterval(() => {
                    this.countDownNum -= 1

                    if (this.countDownNum <= 0) {
                        this.isCountDown = false
                        this.soundPlay(startSound)

                        window.clearInterval(timer)
                        this.countTimer()//30秒を測る関数
                        this.showFirstProblem() //問題をだす関数

                        return
                    }
                    countSound.currentTime = 0
                    countSound.play()
                },1000)
            },
            showFirstProblem: function() {
                //効果音よみとり
                const okSound = new Audio('../sounds/Quiz-Correct_Answer02-1.mp3')
                const ngSound = new Audio('../sounds/Quiz-Wrong_Buzzer02-1.mp3')
                const nextSound = new Audio('../sounds/Quiz-Question03-1.mp3')

                //入力イベント時に入力キーと解答キーをチェック
                $(window).on('keypress', e => {
                    console.log(e.which)
                    
                    if (e.which === this.problemKeyCodes[this.currentWordNum]) {
                        console.log('正解！！')
                        
                        this.soundPlay(okSound)
                        ++this.currentWordNum
                        ++this.wpm
                        console.log('現在解答の文字数目' + this.currentWordNum)

                        //全部おわったらつぎの問題へ
                        if (this.currentWordNum === this.totalWordNum) {
                            console.log('次の問題へ')
                            ++this.currentProblemNum
                            this.currentWordNum = 0
                            
                            this.soundPlay(nextSound)
                        }
                    } else {
                        console.log('不正解！！')

                        this.soundPlay(ngSound)
                        ++this.missNum

                        console.log('現在解答の文字数目' + this.currentWordNum)
                    }
                })
            },
            soundPlay: function(sound) {
                sound.currentTime = 0
                sound.play()
            },
            countTimer: function () {
                const endSound = new Audio('../sounds/Wind_Chimes03-24(Reverb-Fast-Down-High).mp3')

                let timer = window.setInterval(() => {
                    this.timerNum -= 1
                    if(this.timerNum <= 0) {
                        this.isEnd = true
                        window.clearInterval(timer)
                        endSound.play()
                    }
                }, 1000)
            },
            backMove: function() {
                history.back()
            }
        }
    }
</script>
