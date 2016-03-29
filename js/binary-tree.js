function Node(value) {
	this.value = value;
	this.rightChild = null;
	this.leftChild = null;
}

function BinaryTree() {
	this.root = null;
	this.orderedList = [];

	this.addNode = function (value) {
		this.valuePlaced = false;
		if (this.root == null) {
			this.root = new Node(value);
		} else {
			this.currentNode = this.root;
			this.valuePlaced = false;
			while (!this.valuePlaced) {
				if (value[1] < this.currentNode.value[1]) {
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

	function recursiveSearch(node, list) {
		if (node != null) {
			recursiveSearch(node.leftChild, list);
			list.push(node.value);
			recursiveSearch(node.rightChild, list);
		}
	}

	this.getOrderedValues = function() {
		this.orderedList = [];
		recursiveSearch(this.root, this.orderedList);
		return this.orderedList;
	}
}