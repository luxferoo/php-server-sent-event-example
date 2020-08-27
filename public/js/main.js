initMembers()
handleInputMessageChange()

let source
let selectedMemberId
let lastMessageId

function initMembers() {
    fetch('/members', {method: 'GET'})
        .then(response => response.json())
        .then(members => {
            const chatMembersDOM = document.querySelector("#chat_members")
            members.forEach(({id, username}) => {
                const div = document.createElement('div')
                div.setAttribute('class', 'chat__member')
                div.setAttribute('id', `member_${id}`)
                div.onclick = handleMemberClicked
                div.innerText = username
                chatMembersDOM.append(div)
            })
        });
}

function handleMemberClicked({target: {id}}) {
    const members = document.querySelectorAll('.chat__member.selected')
    if (members) {
        members.forEach(e => {
            e.classList.remove('selected')
        })
    }

    document
        .querySelector(`#${id}`)
        .classList
        .add('selected');

    if (source instanceof EventSource) {
        source.close()
    }
    source = new EventSource(`/messages/${id.split('_')[1]}`);
    source.onmessage = buildConversation;
    selectedMemberId = id
    clearConversation()
}

function clearConversation() {
    lastMessageId = null
    const chatConversation = document.querySelector('#chat_conversation')
    chatConversation.innerHTML = ''
}

function buildConversation({data}) {
    const fragment = document.createDocumentFragment();
    const chatConversation = document.querySelector('#chat_conversation')
    const connectedMember = document.querySelector('#connected_member')
    const parsedData = JSON.parse(data)

    if(lastMessageId && parsedData[parsedData.length -1].id === lastMessageId){
        return
    }

    lastMessageId = parsedData[parsedData.length -1].id

    parsedData.forEach(message => {
        const div = document.createElement('div')
        let divClass = 'chat__message-left';
        if (message.fromMember == connectedMember.getAttribute('data-id')) {
            divClass = 'chat__message-right'
        }
        div.setAttribute('class', divClass)
        div.innerText = message.message
        fragment.appendChild(div)
    })

    chatConversation.innerHTML = ''
    chatConversation.appendChild(fragment)
    chatConversation.scrollTop  = chatConversation.scrollHeight
}

function sendMessage() {
    if (!canSendMessage()) {
        return
    }
    const inputMessage = document.querySelector('#input_message')
    const body = new FormData()
    body.append('message', inputMessage.value)

    fetch(`/messages/${selectedMemberId.split('_')[1]}`, {
        method: 'POST',
        body
    })
        .then(() => {
        })
        .catch(console.error)
        .finally(() => {
            inputMessage.value = null
            sendButtonStatus()
        })
}

function handleInputMessageChange() {
    const inputMessage = document.querySelector('#input_message')
    inputMessage.addEventListener('change', ({target: {value}}) => {
        sendButtonStatus()
    })
}

function sendButtonStatus() {
    const button = document.querySelector('#send_message')
    if (canSendMessage()) {
        button.removeAttribute('disabled')
    } else {
        button.setAttribute('disabled', 'disabled')
    }
}

function canSendMessage() {
    return selectedMemberId && Boolean(document.querySelector('#input_message').value)
}