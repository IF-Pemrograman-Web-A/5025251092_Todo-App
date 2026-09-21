let todos = [
    {
        title: "PWEB",
        description: "Tugas Bikin Web",
        completed: false
    },
    {
        title: "Teori Graf",
        description: "Cari solusi optimal",
        completed: false
    },
    {
        title: "KKA",
        description: "Buat Implementasi A* Informed Search",
        completed: false
    }
];

const list = document.querySelector(".todo-list");
const form = document.querySelector(".new-todo");

function showTodos() {
    list.innerHTML = "";

    todos.forEach(function(todo, index) {
        const item = document.createElement("div");
        item.classList.add("todo-item");

        item.innerHTML = `
            <div>
                <h3>${todo.title}</h3>
                <p>${todo.description}</p>
            </div>

            <input type="checkbox">

            <span class="status ${todo.completed ? "completed" : "pending"}">
                ${todo.completed ? "Completed" : "Pending"}
            </span>

            <button>Edit</button>
            <button>Delete</button>
        `;

        const checkbox = item.querySelector("input");

        checkbox.checked = todo.completed;

        checkbox.addEventListener("change", function() {
            todo.completed = checkbox.checked;
            showTodos();
        });

        const buttons = item.querySelectorAll("button");

        buttons[0].addEventListener("click", function() {
            const newTitle = prompt("Enter new title:", todo.title);

            if (newTitle !== null && newTitle !== "") {
                todo.title = newTitle;
                showTodos();
            }
        });

        buttons[1].addEventListener("click", function() {
            todos.splice(index, 1);
            showTodos();
        });

        list.appendChild(item);
    });
}

form.addEventListener("submit", function(event) {
    event.preventDefault();

    const title = document.querySelector("#title").value;
    const description = document.querySelector("#description").value;

    if (title === "" || description === "") {
        return;
    }

    todos.push({
        title: title,
        description: description,
        completed: false
    });

    form.reset();

    showTodos();
});

const darkButton = document.createElement("button");

darkButton.textContent = "Light / Dark Mode";

darkButton.addEventListener("click", function() {
    document.body.classList.toggle("dark-mode");
});

document.querySelector(".detail-panel").appendChild(darkButton);

showTodos();
