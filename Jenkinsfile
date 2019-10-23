pipeline {
    agent any
    environment {
        PRODUCTION_HOST = credentials("PRODUCTION_HOST")
        PRODUCTION_PORT = credentials("PRODUCTION_PORT")
        PRODUCTION_PATH = credentials("PRODUCTION_PATH")
    }
    stages {
        stage("Init") {
            steps {
                sh "make refresh"
            }
        }
        stage("Lint") {
            steps {
                sh "make lint"
            }
        }
        stage("Test") {
            steps {
                sh "make test"
            }
        }
        stage("Down") {
            steps {
                sh "make docker-down-clear"
            }
        }
        stage ('Prod') {
            when {
                branch "master"
            }
            steps {
                sshagent (credentials: ['production']) {
                    sh "HOST=${env.PRODUCTION_HOST} PORT=${env.PRODUCTION_PORT} DIR=${env.PRODUCTION_PATH} REVISION=${env.GIT_COMMIT} make deploy"
                }
            }
        }
    }
    post {
        always {
            sh "make docker-down-clear || true"
        }
    }
}
