function Node(value) {
	this.value = value;
	this.rightChild = null;
	this.leftChild = null;
}

function BinaryTree() {
	this.root = null;
	this.orderedList = [];

	this.addNode = function (value) {
		//this.valuePlaced = false;
		//check if this binary tree's root node (top) is null, if it is, make it equal to the new value
		if (this.root == null) {
			this.root = new Node(value);
		} else {
			//currentNode is a variable that will hold the current node that is being looked at
			//it is of the type Node and so it will have a value, right child and left child
			this.currentNode = this.root;
			//set value placed to false so that the while loop will keep going untill the algorithm finds a location
			//to place the new value
			this.valuePlaced = false;
			while (!this.valuePlaced) {
				//if the parameter value is less than that of the current node's value it goes to the left side of it
				if (value[1] <= this.currentNode.value[1]) {
					//if the current node does not have a left child make its left child equal to the parameter value
					//and set valuePlaced to true so the loop does not happpen again
					if (this.currentNode.leftChild == null) {
						this.currentNode.leftChild = new Node(value);
						this.valuePlaced = true;
					} else {
						//if not make currentNode become the current node's left child so we can compare it to the parameter value
						//in the next pass of the loop
						this.currentNode = this.currentNode.leftChild;
					}
				} else {
					//same as above for the right child
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