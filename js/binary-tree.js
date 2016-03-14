function Node(value) {
	this.value = value;
	this.rightChild = null;
	this.leftChild = null;
}

function BinaryTree() {
	this.root = null;
	this.valuePlaced = false;

	function addNode(value) {
		this.valuePlaced = false;
		if (this.root == null) {
			this.root = new Node(value);
		} else {
			var this.currentNode = this.root;
			while (!valuePlaced) {
				if (value < this.currentNode.value) {
					if (this.currentNode.leftChild == null) {
						this.currentNode.leftChild = new Node(value);
						this.valuePlaced = true;
					} else {
						this.currentNode = this.currentNode.leftChild;
					}
				} else {
					if (this.currentNode.rightChild == null) {
						this.currentNode.rightChild = new Node(value);
						this.valuePlaced = true;
					} else {
						this.currentNode = this.currentNode.rightChild;
					}
				}
			}	
		}
	}

	function recursiveSearch(node) {
		var this.orderedList = [];
		if (node != null) {
			recursiveSearch(node.leftChild);
			this.orderedList.push(node.value);
			recursiveSearch(node.rightChild);
		}
		return this.orderedList;
	}

	function getOrderedValues() {
		return recursiveSearch(this.root);
	}
}