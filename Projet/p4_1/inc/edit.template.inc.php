<div id="f_edit">
    <div class="Toolbar">
        <p>- Toolbar -</p></br>
      <span><label>Color:</label>
      <div id="colorSelector"><div style="background-color: black"></div></div></span>
      <span><label>Image File : </label>
      <input type="file" id="imageLoader" name="imageLoader"/></span>
      <span><label>Max Size : </label>
        <input type="number" id="imageMaxSize" step="1" max="600" min="200" value="600" /></span>
      <span><label>Thickness :</label>
        <input type="range" value="3" min="1" max="10" step="1" onchange="changeThickness(this.value, this)"><span id="thicknessShower"><div></div></span></span>
    </div>
    <div class="CanvasContainer">
        <canvas id="drawingCanvas" width="500" height="300"></canvas>
    </div>
    <div class="Toolbar">
        <p>- Operations -</p></br>
        <button onclick="saveCanvas()">Save the Canvas</button>
        <button onclick="clearCanvas()">Clear the Canvas</button>
        <div id="savedCopyContainer">
            <img id="savedImageCopy"><br>
            Right-click to save ...
        </div>
    </div>
</div>