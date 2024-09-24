var TodoList = artifacts.require("./UserRegistry.sol");

module.exports = function(deployer) {
  deployer.deploy(TodoList);
};