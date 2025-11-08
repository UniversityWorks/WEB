const block = document.getElementById('myBlock');
const h1 = document.querySelector('h1');

block.addEventListener('mousemove', function(event) {
    const rect = block.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - 32;
  h1.textContent = `Координати: x=${x}, y=${y}`;
});

block.addEventListener('mouseleave', function() {
    h1.textContent = 'Координати: x=0, y=0';
});


const list1 = document.getElementById('list1');
const list2 = document.getElementById('list2');
const moveRight = document.getElementById('moveRight');
const moveLeft = document.getElementById('moveLeft');

function moveSelectedItems(sourceList, targetList) {
    const selectedOptions = Array.from(sourceList.selectedOptions);
    selectedOptions.forEach(option => {
        targetList.add(option);
    });
    sortList(targetList);
}

function sortList(list) {
    const options = Array.from(list.options);
    options.sort((a, b) => a.text.localeCompare(b.text));
    options.forEach(option => list.add(option)); 
}

moveRight.addEventListener('click', () => {
    moveSelectedItems(list1, list2);
});

moveLeft.addEventListener('click', () => {
    moveSelectedItems(list2, list1);
});


     const inputArea = document.getElementById('inputArea');
    const grid = document.getElementById('grid');

    function generateGrid() {
        grid.innerHTML = ''; 
        const input = inputArea.value.trim();
        const rows = input.split('\n');

        rows.forEach(row => {
            const rowContainer = document.createElement('div');
            rowContainer.style.display = 'grid';
            rowContainer.style.gridTemplateColumns = `repeat(${row.length}, 25px)`;

            for (let i = 0; i < row.length; i++) {
                const square = document.createElement('div');
                square.classList.add('square');
                if (row[i] === '1') {
                    square.classList.add('black');
                } else if (row[i] === '0') {
                    square.classList.add('white');
                }
                rowContainer.appendChild(square);
            }

            grid.appendChild(rowContainer);
        });
    }
    inputArea.addEventListener('input', generateGrid);


    const block2 = document.getElementById('block2');
    
    const widthRange = document.getElementById('widthRange');
    const widthInput = document.getElementById('widthInput');

    const heightRange = document.getElementById('heightRange');
    const heightInput = document.getElementById('heightInput');

    const rotateRange = document.getElementById('rotateRange');
    const rotateInput = document.getElementById('rotateInput');

    function updateBlock() {
        block2.style.width = `${widthRange.value}px`;
        block2.style.height = `${heightRange.value}px`;
        block2.style.transform = `rotate(${rotateRange.value}deg)`;
    }

    widthRange.addEventListener('input', () => {
        widthInput.value = widthRange.value;
        updateBlock();
    });
    widthInput.addEventListener('input', () => {
        widthRange.value = widthInput.value;
        updateBlock();
    });

    heightRange.addEventListener('input', () => {
        heightInput.value = heightRange.value;
        updateBlock();
    });
    heightInput.addEventListener('input', () => {
        heightRange.value = heightInput.value;
        updateBlock();
    });

    rotateRange.addEventListener('input', () => {
        rotateInput.value = rotateRange.value;
        updateBlock();
    });
    rotateInput.addEventListener('input', () => {
        rotateRange.value = rotateInput.value;
        updateBlock();
    });
