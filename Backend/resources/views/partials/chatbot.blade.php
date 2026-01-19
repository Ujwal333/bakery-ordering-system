<!-- Chatbot Toggle Icon -->
<div id="chatbot-toggle" class="chatbot-toggle">
    <i class="fas fa-comment-dots"></i>
</div>

<!-- Chatbot Window -->
<div id="chatbot-window" class="chatbot-window">
    <div class="chatbot-header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div class="chatbot-avatar">C</div>
            <div>
                <div style="font-weight: 700; font-size: 14px;">Cinnamon Assistant</div>
                <div style="font-size: 11px; opacity: 0.8; display: flex; align-items: center; gap: 4px;">
                    <span class="status-dot"></span> Online
                </div>
            </div>
        </div>
        <i class="fas fa-times" id="chatbot-close" style="cursor: pointer;"></i>
    </div>
    
    <div class="chatbot-messages" id="chatbot-messages">
        <!-- Messages will be injected here -->
    </div>
    
    <div class="chatbot-input-area" id="chatbot-input-area">
        <!-- Input or Buttons will be here -->
    </div>
</div>

<style>
    .chatbot-toggle {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 10px 25px rgba(255, 159, 28, 0.4);
        z-index: 1000;
        transition: all 0.3s ease;
    }
    .chatbot-toggle:hover {
        transform: scale(1.1);
    }
    
    .chatbot-window {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 350px;
        max-height: 500px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.15);
        z-index: 1000;
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: slideUp 0.3s ease;
    }
    
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .chatbot-header {
        background: var(--secondary);
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .chatbot-avatar {
        width: 35px;
        height: 35px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }
    
    .status-dot {
        width: 8px;
        height: 8px;
        background: #2ecc71;
        border-radius: 50%;
    }
    
    .chatbot-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background: #fdf1e6;
        min-height: 300px;
        max-height: 350px;
    }
    
    .msg {
        max-width: 80%;
        padding: 12px 16px;
        border-radius: 15px;
        font-size: 14px;
        line-height: 1.4;
    }
    
    .msg.bot {
        background: white;
        color: var(--secondary);
        align-self: flex-start;
        border-bottom-left-radius: 2px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .msg.user {
        background: var(--primary);
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 2px;
    }
    
    .chatbot-options {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }
    
    .chat-opt-btn {
        background: white;
        border: 1px solid var(--primary);
        color: var(--primary);
        padding: 8px 14px;
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 600;
    }
    
    .chat-opt-btn:hover {
        background: var(--primary);
        color: white;
    }
    
    .chatbot-input-area {
        padding: 15px;
        border-top: 1px solid #eee;
        background: white;
    }
    
    /* Product card inside chat */
    .chat-product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        margin-top: 10px;
        border: 1px solid #eee;
    }
    .chat-product-card img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }
    .chat-product-card div {
        padding: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('chatbot-toggle');
        const windowEl = document.getElementById('chatbot-window');
        const close = document.getElementById('chatbot-close');
        const msgContainer = document.getElementById('chatbot-messages');
        const inputArea = document.getElementById('chatbot-input-area');
        
        let customCakeData = {};

        toggle.addEventListener('click', () => {
            windowEl.style.display = windowEl.style.display === 'flex' ? 'none' : 'flex';
            if (windowEl.style.display === 'flex' && msgContainer.children.length === 0) {
                initChatbot();
            }
        });

        close.addEventListener('click', () => {
            windowEl.style.display = 'none';
        });

        async function initChatbot() {
            addMessage("bot", "Hello! Analyzing our fresh database... 🥨");
            try {
                const res = await fetch(`${API_BASE}/chatbot/init`);
                const data = await res.json();
                
                msgContainer.innerHTML = ''; // Clear loading
                addMessage("bot", data.greeting);
                showOptions(data.options);
            } catch (e) {
                addMessage("bot", "Oops! I'm having trouble connecting right now. Please try again later.");
            }
        }

        function addMessage(sender, text) {
            const div = document.createElement('div');
            div.className = `msg ${sender}`;
            div.innerHTML = text;
            msgContainer.appendChild(div);
            msgContainer.scrollTop = msgContainer.scrollHeight;
        }

        function showOptions(options) {
            const div = document.createElement('div');
            div.className = 'chatbot-options';
            options.forEach(opt => {
                const btn = document.createElement('button');
                btn.className = 'chat-opt-btn';
                btn.innerText = opt.label;
                btn.onclick = () => handleOption(opt);
                div.appendChild(btn);
            });
            msgContainer.appendChild(div);
            msgContainer.scrollTop = msgContainer.scrollHeight;
        }

        async function handleOption(opt) {
            addMessage("user", opt.label);
            
            // Remove previous options to keep it clean
            const lastOptions = msgContainer.querySelector('.chatbot-options:last-child');
            // if(lastOptions) lastOptions.remove(); // Optional: keep history or remove

            switch(opt.value) {
                case 'order_regular':
                    addMessage("bot", "Great! What are you craving today?");
                    const res = await fetch(`${API_BASE}/chatbot/init`);
                    const data = await res.json();
                    const catOptions = data.categories.map(c => ({ label: c.name, value: `cat_${c.id}`, id: c.id }));
                    showOptions(catOptions);
                    break;
                
                case 'order_custom':
                    addMessage("bot", "Exciting choice! Let's start designing your masterpiece. 🎨");
                    startCustomCakeFlow();
                    break;

                case 'view_menu':
                    addMessage("bot", "Directing you to our full menu... 📜");
                    setTimeout(() => window.location.href = `${BASE_URL}/menu`, 1000);
                    break;

                case 'delivery_info':
                    addMessage("bot", "We deliver across Kathmandu Valley! 🚚<br><br>Standard: Rs 50<br>Same Day: Order before 11 AM.");
                    showRestart();
                    break;

                case 'contact_support':
                    addMessage("bot", "Need more help? Our team is available at <b>+977 1234567890</b> or use our contact form.");
                    setTimeout(() => window.location.href = `${BASE_URL}/#contact`, 1500);
                    break;

                case 'restart':
                    initChatbot();
                    break;

                default:
                    if(opt.value && opt.value.startsWith('cat_')) {
                        const catId = opt.id;
                        fetchProducts(catId);
                    }
                    break;
            }
        }

        async function fetchProducts(catId) {
            const res = await fetch(`${API_BASE}/chatbot/products?category_id=${catId}`);
            const data = await res.json();
            
            if(data.products.length === 0) {
                addMessage("bot", "We're currently refilling this category. Try another one!");
                return;
            }

            addMessage("bot", "Here are some of our best picks:");
            data.products.forEach(p => {
                const pDiv = document.createElement('div');
                pDiv.className = 'chat-product-card';
                pDiv.innerHTML = `
                    <img src="${p.image_url}">
                    <div>
                        <div style="font-weight:700;">${p.name}</div>
                        <div style="color:var(--primary); font-size:12px;">Rs. ${p.price}</div>
                        <button class="chat-opt-btn" style="width:100%; margin-top:8px;" onclick="window.location.href='/menu/${p.slug}'">View Details</button>
                    </div>
                `;
                msgContainer.appendChild(pDiv);
            });
            showRestart();
        }

        async function startCustomCakeFlow() {
            const res = await fetch(`${API_BASE}/chatbot/custom-steps`);
            const data = await res.json();
            askStep(data.steps, 0);
        }

        function askStep(steps, index) {
            if(index >= steps.length) {
                addMessage("bot", "Perfect! I've prepared your custom designer session. Let's finish it there!");
                setTimeout(() => window.location.href = '/custom-cake', 2000);
                return;
            }

            const step = steps[index];
            addMessage("bot", step.question);
            const opts = step.options.map(o => ({ label: o, value: `step_${index}`, stepValue: o }));
            
            const div = document.createElement('div');
            div.className = 'chatbot-options';
            opts.forEach(opt => {
                const btn = document.createElement('button');
                btn.className = 'chat-opt-btn';
                btn.innerText = opt.label;
                btn.onclick = () => {
                    addMessage("user", opt.label);
                    askStep(steps, index + 1);
                };
                div.appendChild(btn);
            });
            msgContainer.appendChild(div);
            msgContainer.scrollTop = msgContainer.scrollHeight;
        }

        function showRestart() {
            showOptions([{ label: "🔄 Start Over", value: 'restart' }]);
        }

        // Handle Restart Global
        window.handleRestart = () => initChatbot();
    });
</script>
